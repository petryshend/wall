<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Record;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {
        $records = $this->getDoctrine()->getRepository('AppBundle:Record')->findAll();

        return $this->render(
            'wall.html.twig',
            [
                'records' => $records
            ]
        );
    }

    /**
     * @Route("/record/create", name="record_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $record = new Record();

        $form = $this->createFormBuilder($record)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Record'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $record = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($record);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'record/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
