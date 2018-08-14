<?php

namespace App\Consumer\EventListener;

//use Consumer\Manager\FilaMensagensManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ConviteNovoCriado implements ConsumerInterface
{
    const TENTATIVAS_MAXIMAS_PERMITIDAS = 3;
    const TEMPO_MAXIMO_ESPERA_EM_MINUTOS = 10;

//    private $logger; // Monolog-logger.

//    /** @var FilaMensagensManager */
//    protected $filaMessagensManager;

//    /** @var NotificacaoManager */
//    protected $notificacaoManager;

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

//    /**
//     * @return NotificacaoManager
//     */
//    public function getNotificacaoManager(): NotificacaoManager
//    {
//        return $this->notificacaoManager;
//    }
//
//    /**
//     * @param NotificacaoManager $notificacaoManager
//     */
//    public function setNotificacaoManager(NotificacaoManager $notificacaoManager)
//    {
//        $this->notificacaoManager = $notificacaoManager;
//    }

    // Init:
    public function __construct(  )
    {
//        $this->logger = $logger;
        echo "Convite novo criado is listening...";
    }

    public function execute(AMQPMessage $msg)
    {

        $body = unserialize($msg->getBody());

        if (array_key_exists('destinatario', $body )){

            $index = 'destinatario';

//            if ($this->getFilaMessagensManager()->verificarPodeProcessarMsg(
//                $body,
//                self::TENTATIVAS_MAXIMAS_PERMITIDAS,
//                self::TEMPO_MAXIMO_ESPERA_EM_MINUTOS,
//                $index)
//            ){
//
////                $this->getNotificacaoManager()->notificarInteressadoConviteNovoCriado( $body['destinatario'] );
//            }
        }

        echo "\nConvite Novo criado e notificados os interessados.";

    }
}