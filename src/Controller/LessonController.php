<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lesson;
use App\Entity\Child;
use App\Entity\Hour;
use App\Form\LessonType;
use App\Form\ChildType;
use App\Service\DateArray;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

function getDatesFromRange($start, $end, $format='Y-m-d') {
    return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
    },
    range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
}

class LessonController extends AbstractController
{
    /**
     * @Route("/lesson", name="lesson")
     */
    public function index(Request $request)
    {   
        $today = date('Y-m-d');
        $dateInTwoWeeks = date('Y-m-d', strtotime('+2 weeks'));
        $date = getDatesFromRange($today, $dateInTwoWeeks);
        $repository = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repository->findAll();

        $repository2 = $this->getDoctrine()->getRepository(Hour::class);
        $hour = $repository2->findAll();
        
        $em = $this->getDoctrine()->getManager();

        $week2 = false;
        
        foreach($date as $d){
            foreach($hour as $h){
                if(!$repository->findByDateTime($d, $h)){   
                    $d2 = \DateTime::createFromFormat('Y-m-d', $d);
                    $lessonTmp = new Lesson();
                    $lessonTmp->setDate($d2);
                    $lessonTmp->setHour($h);
                    $lessonTmp->setAvailable(false);
                    $em->persist($lessonTmp);
                    $em->flush();
                }                  
            }
        } 
        if ($request->isXMLHttpRequest()) { 
            $template = $this->render('lesson/index.html.twig', ['lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2,])->getContent();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            return $response->setData(['template' => $template, 'lesson' => $lesson, 'dates' => $date, "hours" => $hour,
            'week' => $week2, ]); 
        }
        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2,
        ]);
    }

    /**
     * @Route("/lesson/week2", name="lesson2")
     */
    public function index2(Request $request)
    {   
        $today = date('Y-m-d', strtotime('+1 week'));
        $dateInTwoWeeks = date('Y-m-d', strtotime('+2 weeks'));
        $date = getDatesFromRange($today, $dateInTwoWeeks);
        $repository = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repository->findAll();

        $repository2 = $this->getDoctrine()->getRepository(Hour::class);
        $hour = $repository2->findAll();
        
        $em = $this->getDoctrine()->getManager();
        
        $week2 = true;
                
        if ($request->isXMLHttpRequest()) { 
            $template = $this->render('lesson/index.html.twig', ['lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2,])->getContent();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            return $response->setData(['template' => $template, 'lesson' => $lesson, 'dates' => $date, "hours" => $hour,
            'week' => $week2, ]); 
        }
        return new Response('This is not ajax!', 400);
    }

     /**
     * @Route("/lesson/edit/{id}", name="edit")
     */
    public function edit(Lesson $lesson, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //don't wanna change date and time, so get it form current object
            $lesson->setDate($lesson->getDate($lesson));
            $lesson->setHour($lesson->getHour($lesson));
            //if($lesson->getChild1() != null){
            //    $lesson->setChild1($lesson->getChild1($lesson)); 
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/edit.html.twig', [
            'form' => $form->createView() , 'lesson' => $lesson ,
        ]);
    }

    
}
