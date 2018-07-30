<?php
namespace Convite\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;

class ConviteManager
{

    /** @var ObjectManager */
    protected $om;

    public function __construct( ObjectManager $om )
    {
        parent::__construct($om);
    }

    /**
     * get convite per ID
     *
     * @param $id
     * @return null|object
     */
    public function get( $id ){

        $conviteRepo = $this->om->getRepository('AppEntity:Convite');

        return $convite = $conviteRepo->findOneBy([ 'id' => $id ]);
    }
}
