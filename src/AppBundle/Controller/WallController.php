<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {
        return $this->render('wall.html.twig');
    }
}
