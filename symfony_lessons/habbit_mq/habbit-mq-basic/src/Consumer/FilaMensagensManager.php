<?php
namespace Consumer\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;

class FilaMensagensManager
{
    const CONVITE_NOVO_CRIADO = 'convite_novo_criado';
    const CONVITE_ACEITO_NOTIFICACAO = 'convite_aceito_notificacao';
    const CONVITE_ACEITO_HOOK = 'convite_aceito_hook';
    const CONVITE_PENDENTES_NOTIFICACAO ='convite_pendentes_notificacao';

    protected $conviteNovoCriadoProducer;

    protected $conviteHookProducer;

    protected $convitePendenteNotificacaoProducer;

    protected $conviteAceitoNotificacaoProducer;

    /**
     * @return mixed
     */
    public function getConviteNovoCriadoProducer()
    {
        return $this->conviteNovoCriadoProducer;
    }

    /**
     * @param mixed $conviteNovoCriadoProducer
     */
    public function setConviteNovoCriadoProducer($conviteNovoCriadoProducer)
    {
        $this->conviteNovoCriadoProducer = $conviteNovoCriadoProducer;
    }

    /**
     * @return mixed
     */
    public function getConviteHookProducer()
    {
        return $this->conviteHookProducer;
    }

    /**
     * @param mixed $conviteHookProducer
     */
    public function setConviteHookProducer($conviteHookProducer)
    {
        $this->conviteHookProducer = $conviteHookProducer;
    }

    /**
     * @return mixed
     */
    public function getConvitePendenteNotificacaoProducer()
    {
        return $this->convitePendenteNotificacaoProducer;
    }

    /**
     * @param mixed $convitePendenteNotificacaoProducer
     */
    public function setConvitePendenteNotificacaoProducer($convitePendenteNotificacaoProducer)
    {
        $this->convitePendenteNotificacaoProducer = $convitePendenteNotificacaoProducer;
    }

    /**
     * @return mixed
     */
    public function getConviteAceitoNotificacaoProducer()
    {
        return $this->conviteAceitoNotificacaoProducer;
    }

    /**
     * @param mixed $conviteAceitoNotificacaoProducer
     */
    public function setConviteAceitoNotificacaoProducer($conviteAceitoNotificacaoProducer)
    {
        $this->conviteAceitoNotificacaoProducer = $conviteAceitoNotificacaoProducer;
    }

    public function __construct( ObjectManager $om )
    {
        parent::__construct($om);
    }

    /**
     * Enviar mensagem para a fila do RabbitMQ
     *
     * @param $message
     */
    public function enviarFilaMensagem( $message, $action ){

        $producer = $this->obtemProducerConformeAcao( $action );

        if ( $producer != null )
            $producer->publish(serialize($message));
    }

    /**
     * Retorna o producer conforme ação.
     *
     * @param string $action
     * @return mixed|null
     */
    public function obtemProducerConformeAcao( $action = '' ){

        $producer = null;

        switch ($action) {
            case self::CONVITE_NOVO_CRIADO:
                $producer = $this->getConviteNovoCriadoProducer();
                break;
            case  self::CONVITE_ACEITO_NOTIFICACAO:
                $producer = $this->getConviteAceitoNotificacaoProducer();
                break;
            case  self::CONVITE_ACEITO_HOOK:
                $producer = $this->getConviteHookProducer();
                break;
            case  self::CONVITE_PENDENTES_NOTIFICACAO:
                $producer = $this->getConvitePendenteNotificacaoProducer();
                break;
        }

        return $producer;
    }

    /**
     * @param array $convitesPendente
     * @return null
     */
    public function enviarFilaMensagemConvitesPendente( $convitesPendente = [], $action ){

        if ( !sizeof($convitesPendente) > 0 ) return null;

        foreach ( $convitesPendente as $convitePendente ){

            $mensagemPreparada = $this->preparaMensagemConvite( $convitePendente );

            $this->enviarFilaMensagem( $mensagemPreparada, $action );
        }

        return null;
    }

    /**
     * Testes Cobertos
     *
     * Prepara a mensagem de convites pendentes para enviar a fila
     *
     * @param Convite $convitePendente
     * @return array
     */
    public function preparaMensagemConvite( Convite $convitePendente ){

        $mensagem['destinatario'] = [

            'nome'      => $convitePendente->getNome(),
            'email'     => $convitePendente->getEmail(),
            'conviteId' => $convitePendente->getId()
        ];

        return $mensagem;
    }

    /**
     * Testes Cobertos
     * Itera sobre os emails e cria mensagem para que seja notificados.
     *
     * @param array $infoJson
     * @return null|array
     */
    public function notificaEmailsFilaMsg( Convite $convite, $action ){

        $infoJson = $convite->getProdutosJson()[0];

        if ( !array_key_exists( 'notificar_emails', $infoJson ) ) return null;

        $destinatariosNotificar = $infoJson['notificar_emails'];

        if ( !sizeof($destinatariosNotificar) > 0 ) return null;

        $mensagensEviadas = [];

        foreach ( $destinatariosNotificar as $destinatario ){

            $msg['destinatario'] = [
                    'nome' => array_key_exists( 'nome', $destinatario ) ? $destinatario['nome'] : 'nome não definido',
                    'email' => array_key_exists( 'email', $destinatario ) ? $destinatario['email'] : 'email não definido',
                    'conviteId' => $convite->getId()
                ];

            $this->enviarFilaMensagem( $msg, $action );

            $mensagensEviadas[] = $msg;
        }

        return $mensagensEviadas;
    }

    /**
     * Testes Cobertos
     * itera sobre os hooks e criar mensagem para que eles sejam executados.
     *
     * @param array $infoJson
     * @param EmpresaUsuarioConvite $convite
     * @return null|integer
     */
    public function enviarHooksFila(  EmpresaUsuarioConvite $convite ){

        $infoJson = $convite->getProdutosJson()[0];

        if ( !array_key_exists( 'hooks', $infoJson ) ) return null;

        $urlsHooks = $infoJson['hooks'];

        if ( !sizeof($urlsHooks) > 0 ) return null;

        $qtdHooksEnviadosFila = 0;

        foreach ( $urlsHooks as $hook ){

            $hook['url'];

            $msg['hooks'] = [
                'url' => $hook['url'],
                'conviteId' => $convite->getId()
            ];

            $this->enviarFilaMensagem( $msg, FilaMensagensManager::CONVITE_ACEITO_HOOK );
            $qtdHooksEnviadosFila += 1;
        }

        return $qtdHooksEnviadosFila;
    }


    /**
     * Testes Cobertos
     * Com base nas url da msg, processa as url e caso ocorra erro a msg é reenviada para fila.
     *
     * @param array $msg
     * @param EmpresaUsuarioConvite|null $convite
     * @return null
     */
    public function executarHook( $msg = [], EmpresaUsuarioConvite $convite = null ){

        $index = 'hook';

        if (!is_object($convite)) return false;
        if (!array_key_exists( $index, $msg )) return false;
        if (!array_key_exists( 'url', $msg[$index] )) return false;

        $url = $msg['hook']['url'];

        if ( !$this->processarUrl( $url, $convite ) ){

            $this->reenviarParaFila( $msg, self::CONVITE_ACEITO_HOOK, $index );
            return false;
        }

        return true;
    }


    /**
     * Processa uma url usando o guzzle e returna true or false.
     * Teste coberto.
     * @param string $url
     * @param $postParams
     * @return bool|null
     */
    public function processarUrl( $url = '', $postParams ){

        if ( $url == '' ) return false;

        $client = new Client();

        try {

            $response = $client->request('POST', $url,
                [
                    'form_params' => [
                        'data' => json_encode($postParams)
                    ],
                    'verify' => false
                ]
            );

            $result = true;

        }catch ( \GuzzleHttp\Exception\GuzzleException $e){

            $result = false;
        }

        return $result;
    }


    /**
     * Testes cobertos
     * $tempoEspera em minutos.
     *
     * @param array $params
     * @param $qtdTentativasPermitidas
     * @param $tempoEspera
     * @return bool
     */
    public function verificarPodeProcessarMsg( $msg = [], $qtdTentativasPermitidas, $tempoEspera, $index ){

        $params = $msg[$index];

        if ( !array_key_exists( 'data_ultima_tantativa', $params ) and !array_key_exists( 'qtd_tentativas', $params ) )
            return true;

        $qtdTentativaAtual = $params['qtd_tentativas'];

        /** @var \DateTime $dateUltimaTentativa */
        $dateUltimaTentativa = $params['data_ultima_tantativa'];

        if ( $qtdTentativaAtual > $qtdTentativasPermitidas ) return false;

        $dateCompare = strtotime($dateUltimaTentativa);

        //Caso o tempo de espera não tenha sido atingido, reenviar para a fila novamente.
        if ((time() - $dateCompare <= $tempoEspera * 60)) {

            $this->reenviarParaFila( $msg, FilaMensagensManager::CONVITE_PENDENTES_NOTIFICACAO, $index );
            return false;
        }

        return true;
    }


    /**
     * Reenvia mensagem novamente para a fila atualizando informações do processamento.
     *
     * @param array $msg
     * @param $actions
     * @param $prefix
     * @param $qtdTentativasAtual
     * @return $msg atualizada.
     */
    public function reenviarParaFila( $msg = [], $actions, $index ){

        $dataAtual = new \DateTime('now');

        $qtdTentativasAtual = !array_key_exists( 'qtd_tentativas', $msg[$index] )
                                    ? $qtdTentativasAtual = 0
                                    : $qtdTentativasAtual = $msg[$index]['qtd_tentativas'];

        $qtdTentativasAtual += 1;

        $msg[$index]['data_ultima_tantativa'] =  $dataAtual->format('Y-m-d H:i:s');
        $msg[$index]['qtd_tentativas'] =  $qtdTentativasAtual;

        $this->enviarFilaMensagem( $msg, $actions );

        return $msg;
    }
}
