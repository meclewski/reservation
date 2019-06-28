<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lesson;
use App\Entity\Child;
use App\Entity\Hour;
use App\Form\AdminType;
use App\Repository\LessonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


function getDatesFromRange2($start, $end, $format='Y-m-d') {
    return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
    },
    range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
}

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {   
        $today = date('Y-m-d');
        $dateInTwoWeeks = date('Y-m-d', strtotime('+2 weeks'));
        $date = getDatesFromRange2($today, $dateInTwoWeeks);
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
            $template = $this->render('admin/index.html.twig', ['lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2,])->getContent();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            return $response->setData(['template' => $template, 'lesson' => $lesson, 'dates' => $date, "hours" => $hour,
            'week' => $week2, ]); 
        }
        return $this->render('admin/index.html.twig', [
            'lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2, 
        ]);
    }

    /**
     * @Route("/admin/week2", name="adminweek2")
     */
    public function index2(Request $request)
    {   
        $today = date('Y-m-d', strtotime('+1 week'));
        $dateInTwoWeeks = date('Y-m-d', strtotime('+2 weeks'));
        $date = getDatesFromRange2($today, $dateInTwoWeeks);
        $repository = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repository->findAll();

        $repository2 = $this->getDoctrine()->getRepository(Hour::class);
        $hour = $repository2->findAll();

        $week2 = true;
                
        
        if ($request->isXMLHttpRequest()) { 
            $template = $this->render('admin/index.html.twig', ['lesson' => $lesson, 'dates' => $date, "hours" => $hour, 'week' => $week2,])->getContent();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            return $response->setData(['template' => $template, 'lesson' => $lesson, 'dates' => $date, "hours" => $hour,
            'week' => $week2, ]); 
        }
        return new Response('This is not ajax!', 400);
    }

    /**
     * @Route("/admin/show/{lesson_id}", name="confirm")
     */
    
    public function edit(Request $request, LessonRepository $lessonRepository, $lesson_id): Response
    {
        $lesson = $lessonRepository->find($lesson_id);
        
        $repository = $this->getDoctrine()->getRepository(Child::class);
        $children = $repository->findAllInLesson($lesson_id);
       

        for($i = 1; $i <= count($children); $i++){
            $child = $children[$i-1];
            //${"form$i"} = $this->createForm(AdminType::class, $child);
            $formFactory = $this->get('form.factory');
            ${"form$i"} = $formFactory->createNamed("form$i", AdminType::class, $child);
        }

        $entityManager = $this->getDoctrine()->getManager();

        if(isset($form1)){
            $form1->handleRequest($request);
            if ($form1->isSubmitted() && $form1->isValid()) {
                $child = $form1->getData();
                //$child->setConfirmed(true);
                $entityManager->persist($child);
                $entityManager->flush();

                return $this->redirectToRoute('confirm', ['lesson_id' => $lesson_id, 'lesson' => $lesson ]);
            }
        }

        if(isset($form2)){
            $form2->handleRequest($request);    
            if ($form2->isSubmitted() && $form2->isValid()) {
                $child = $form2->getData();
                //$child->setConfirmed(true);
                $entityManager->persist($child);
                $entityManager->flush();

                return $this->redirectToRoute('confirm', ['lesson_id' => $lesson_id, 'lesson' => $lesson ]);
            }
        }

        if(isset($form3)){
            $form3->handleRequest($request);
            if ($form3->isSubmitted() && $form3->isValid()) {
                $child = $form3->getData();
                //$child->setConfirmed(true);
                $entityManager->persist($child);
                $entityManager->flush();

                return $this->redirectToRoute('confirm', ['lesson_id' => $lesson_id, 'lesson' => $lesson ]);
            }
        }

        if(isset($form4)){
            $form4->handleRequest($request);
            if ($form4->isSubmitted() && $form4->isValid()) {
               $child = $form4->getData();
               //$child->setConfirmed(true);
               $entityManager->persist($child);
               $entityManager->flush();

               return $this->redirectToRoute('confirm', ['lesson_id' => $lesson_id, 'lesson' => $lesson, ]);
            }
                
        }

        switch (count($children)){
            case 0:
                return $this->render('admin/edit.html.twig', [
                    'lesson' => $lesson,
                ]);
            break;
            case 1:
                return $this->render('admin/edit.html.twig', [
                    'form1' => $form1->createView(), 'lesson' => $lesson,
                ]);
            break;
            case 2:
                return $this->render('admin/edit.html.twig', [
                    'form1' => $form1->createView(), 'form2' => $form2->createView(),'lesson' => $lesson,
                ]);
            break;
            case 3:
                return $this->render('admin/edit.html.twig', [
                    'form1' => $form1->createView(), 'form2' => $form2->createView(), 'form3' => $form3->createView(),'lesson' => $lesson,
                ]);
            break;
            case 4:
            
                return $this->render('admin/edit.html.twig', [
                    'form1' => $form1->createView(), 'form2' => $form2->createView(), 'form3' => $form3->createView(), 'form4' => $form4->createView(),'lesson' => $lesson, 
                    
                ]);
            break;
        }

    }

    /**
     * @Route("/admin/activate/{lesson_id}", name="activate")
     */
    public function activate(Request $request, LessonRepository $lessonRepository, $lesson_id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repository->find($lesson_id);
        $lesson->setAvailable(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($lesson);
        $em->flush();

        return $this->render('admin/activate.html.twig');

    }
}
