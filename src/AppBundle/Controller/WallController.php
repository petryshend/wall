<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Record;
use AppBundle\Form\RecordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {
        $records = $this->getDoctrine()->getRepository('AppBundle:Record')
            ->findBy([], ['active' => 'DESC', 'id' => 'DESC']);

        $form = $this->createForm(RecordType::class, new Record());

        return $this->render(
            'wall.html.twig',
            [
                'records' => $records,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/record/{id}",
     *     name="view_record",
     *     requirements={"id": "\d+"}
     * )
     * @param int $id
     * @return Response
     */
    public function viewRecordAction(int $id): Response
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:Record')->find($id);
        return $this->render('record.html.twig', ['record' => $record]);
    }

    /**
     * @Route(
     *     "/record/create",
     *     name="record_create"
     * )
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $record = new Record();

        $form = $this->createForm(RecordType::class, $record);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $record = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($record);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('create_record.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(
     *     "/record/{id}/toggle-active",
     *     name="record_toggle_active",
     *     methods={"POST"},
     *     requirements={"id": "\d+"}
     * )
     * @param int $id
     * @return Response
     */
    public function toggleActiveAction(int $id): Response
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:Record')->find($id);

        if ($record === null) {
            throw $this->createNotFoundException('No record found with id ' . $id);
        }

        $record->setActive(!$record->getActive());

        $em = $this->getDoctrine()->getManager();
        $em->persist($record);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route(
     *     "/record/{id}/delete",
     *     name="record_delete",
     *     methods={"POST"},
     *     requirements={"id": "\d+"}
     * )
     * @param int $id
     * @return Response
     */
    public function deleteRecordAction(int $id): Response
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:Record')->find($id);

        if ($record === null) {
            throw $this->createNotFoundException('No record found with id ' . $id);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($record);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
