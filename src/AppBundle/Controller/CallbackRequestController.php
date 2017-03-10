<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CallbackRequest;
use ES\KeywordPerformance\AuthorityLabs\KeywordRequest;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallbackRequestController extends Controller
{
    /** @var Client */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * @Route("/request", name="request")
     * @param Request $request
     * @return Response
     */
    public function requestAction(Request $request): Response
    {
        $callbackRequest = new CallbackRequest();
        $callbackRequest->setContent($request->get('json_callback'));
        $callbackRequest->setIp($request->getClientIp());
        $callbackRequest->setTime(new \DateTime('now'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($callbackRequest);
        $manager->flush();

        $jsonCallbackUrl = $request->get('json_callback');
        $result = $this->httpClient->request('GET', $jsonCallbackUrl);
        $dateTime = (new \DateTimeImmutable('now'))->format('Y-m-d.H:i:s');

        $callbackRequest = new CallbackRequest();
        $callbackRequest->setContent((string)$result->getBody());
        $callbackRequest->setIp($request->getClientIp());
        $callbackRequest->setTime($dateTime);

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

        return $this->render('request_list.html.twig', ['callback_requests' => $callBackRequests]);
    }

    /**
     * @Route("/make_request", name="make_request")
     * @return Response
     */
    public function makeKeywordRequestAction()
    {
        $service = $this->get('keyword_request_service');
        $apiToken = $this->getParameter('authority_labs.api_token');
        $keyword = 'pool';
        $callback = $this->getParameter('authority_labs.callback_url');
        $keywordRequest = new KeywordRequest($apiToken, $keyword, $callback);
        $service->makeDelayedRequest($keywordRequest);

        return new Response();
    }
}