<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CallbackRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallbackRequestController extends Controller
{
    /**
     * @Route("/request", name="request")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $callbackRequest = new CallbackRequest();
        $callbackRequest->setContent($request->getContent());
        $callbackRequest->setIp($request->getClientIp());
        $callbackRequest->setTime(new \DateTime('now'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($callbackRequest);
        $manager->flush();

        return new Response('Success');
    }

    /**
     * @Route("/request_list", name="request_list")
     */
    public function listAction(): Response
    {
        $callBackRequests = $this->getDoctrine()->getRepository('AppBundle:CallbackRequest')->findAll();

        usort($callBackRequests, function(CallbackRequest $a, CallbackRequest $b) {
            return $a->getId() < $b->getId();
        });

        dump($callBackRequests);
        return new Response();
    }
}