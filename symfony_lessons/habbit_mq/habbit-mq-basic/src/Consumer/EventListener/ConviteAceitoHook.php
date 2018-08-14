<?php

namespace App\Consumer\EventListener;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ConviteAceitoHook implements ConsumerInterface
{
    const TENTATIVAS_MAXIMAS_PERMITIDAS = 3;
    const TEMPO_MAXIMO_ESPERA_EM_MINUTOS = 10;


//    private $logger; // Monolog-logger.
//
//    /** @var FilaMensagensManager */
//    protected $filaMessagensManager;
//
//    /** @var ConviteManager */
//    protected $conviteManager;
//
//    /**
//     * @return FilaMensagensManager
//     */
//    public function getFilaMessagensManager()
//    {
//        return $this->filaMessagensManager;
//    }
//
//    /**
//     * @param FilaMensagensManager $filaMessagensManager
//     */
//    public function setFilaMessagensManager($filaMessagensManager)
//    {
//        $this->filaMessagensManager = $filaMessagensManager;
//    }
//
//    /**
//     * @return ConviteManager
//     */
//    public function getConviteManager(): ConviteManager
//    {
//        return $this->conviteManager;
//    }
//
//    /**
//     * @param ConviteManager $conviteManager
//     */
//    public function setConviteManager(ConviteManager $conviteManager)
//    {
//        $this->conviteManager = $conviteManager;
//    }

    // Init:
    public function __construct(  )
    {
//        $this->logger = $logger;
        echo "convite aceito hook is listening...";
    }

    public function execute(AMQPMessage $msg)
    {

        $body = unserialize($msg->getBody());

        if (array_key_exists('hooks', $body )){

            $index = 'hooks';

//            if ($this->getFilaMessagensManager()->verificarPodeProcessarMsg(
//                $body,
//                self::TENTATIVAS_MAXIMAS_PERMITIDAS,
//                self::TEMPO_MAXIMO_ESPERA_EM_MINUTOS,
//                $index)
//            ) {
//
//                $id = $body['conviteId'];
//
//                $convite = $this->getConviteManager()->get( $id );
//                echo "Tentativa de executar hook";
//                $this->getFilaMessagensManager()->executarHook($body, $convite);
//            }
        }
    }
}