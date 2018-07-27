<?php

namespace Consumer\EventListener;

use Consumer\Manager\FilaMensagensManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ConviteAceitoHook implements ConsumerInterface
{
    const TENTATIVAS_MAXIMAS_PERMITIDAS = 3;
    const TEMPO_MAXIMO_ESPERA_EM_MINUTOS = 10;


    private $logger; // Monolog-logger.

    /** @var FilaMensagensManager */
    protected $filaMessagensManager;

    /**
     * @return FilaMensagensManager
     */
    public function getFilaMessagensManager()
    {
        return $this->filaMessagensManager;
    }

    /**
     * @param FilaMensagensManager $filaMessagensManager
     */
    public function setFilaMessagensManager($filaMessagensManager)
    {
        $this->filaMessagensManager = $filaMessagensManager;
    }

    // Init:
    public function __construct( $logger )
    {
        $this->logger = $logger;
        echo "convite aceito hook is listening...";
    }

    public function execute(AMQPMessage $msg)
    {

        $body = unserialize($msg->getBody());

        if (array_key_exists('hooks', $body )){

            $index = 'hooks';

            if ($this->getFilaMessagensManager()->verificarPodeProcessarMsg(
                $body,
                self::TENTATIVAS_MAXIMAS_PERMITIDAS,
                self::TEMPO_MAXIMO_ESPERA_EM_MINUTOS,
                $index)
            ) {

                $convite = $this->getContratoConviteManager()->obtemConvitePorId($body['conviteId']);
                echo "Tentativa de executar hook";
                $this->getFilaMessagensManager()->executarHook($body, $convite);
            }
        }
    }
}