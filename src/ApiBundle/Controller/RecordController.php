<?php
namespace ApiBundle\Controller;

use AppBundle\Entity\Record;
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

        $serialized = array_map(function(Record $record) {
            return $record->jsonSerialize();
        }, $records);

        return new JsonResponse($serialized);
    }

    /**
     * @Route("/record/{id}", name="get_record")
     * @param int $id
     * @return Response
     */
    public function recordAction(int $id): Response
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:Record')->find($id);
        return new JsonResponse($record->jsonSerialize());
    }
}