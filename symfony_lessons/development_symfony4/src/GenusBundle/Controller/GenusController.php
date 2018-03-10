<?php

namespace Development\Bundle\GenusBundle\Controller;

use http\Env\Response;

class GenusController
{

    /**
     * @Route("/genus")
     */
    public function showAction(){

        return new Response('Under the sea!');
    }
}