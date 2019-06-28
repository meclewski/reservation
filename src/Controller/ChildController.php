<?php

namespace App\Controller;


use App\Entity\Child;
use App\Entity\Lesson;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChildController extends AbstractController
{
    /**
     * @Route("/child", name="child")
     */
    public function index()
    {
        return $this->render('child/index.html.twig', [
            'controller_name' => 'ChildController',
        ]);
    }

    /**
     * @Route("/child/new/{lesson_id}", name="child_new", methods={"GET","POST"})
     */
    public function new(Request $request, LessonRepository $lessonRepository, $lesson_id): Response
    {
        $child = new Child();
        $lesson = $lessonRepository->find($lesson_id);
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $child->addLesson($lesson);
            $child->setConfirmed(false);
            $entityManager->persist($child);
            $entityManager->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('child/new.html.twig', [
            'child' => $child, 
            'form' => $form->createView(),
        ]);
    }
}
