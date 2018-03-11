<?php

namespace Aquanote\GunesBundle\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GenusController extends Controller
{

    /**
     * @Route("/genus")
     */
    public function showAction(){

        return new Response('Under the sea!');
    }
}