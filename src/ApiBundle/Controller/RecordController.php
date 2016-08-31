<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecordController extends Controller
{
    /**
     * @Route("/records", name="get_records")
     */
    public function recordsAction(): Response
    {
        $records = $this->getDoctrine()->getRepository('AppBundle:Record')->findAll();

        // TODO: serialize this
        return new JsonResponse('Not yet implemented');
    }
}