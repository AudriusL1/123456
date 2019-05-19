<?php
namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class EventController extends AbstractController
{

  /**
   * @Route("/event", name="event")
   */
  public function index()
  {
    $events = $this->getDoctrine()->getRepository
    (Event::class)->findAll();

    $user = $this->get('security.token_storage')->getToken()->getUser();

    $role = $user->getRole();
    if($role == 1)
    {
      return $this->render('event/index.html.twig', array
      ('events' => $events, 'user' => $user));

    }
      return $this->render('event/indexuser.html.twig', array
      ('events' => $events,'user' => $user));

  }

      /**
      * @Route("/myevent", name="myevent")
      */
      public function myevent()
      {
        $events = $this->getDoctrine()->getRepository
        (Event::class)->findAll();

        $user = $this->get('security.token_storage')
        ->getToken()->getUser();

          return $this->render('event/mysubevents.html.twig', array
          ('events' => $events, 'userid' => $user));
      }



    /**
     * @Route("/event/new", name="newevent")
     * Method({"GET", "POST"})
     */
     public function new(Request $request) {
       $event = new event();
       $form = $this->createFormBuilder($event)
       ->add('name', TextType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('description', TextType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('date', DateType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('location', TextType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('price', TextType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('category', EntityType::class, [
         'class' => 'App\Entity\Category',
       ])
       ->add('save', SubmitType::class, array(
         'label' => 'Create',
         'attr' => array('class' => 'btn')))
       ->getForm();

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
         $event = $form->getData();

         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($event);
         $entityManager->flush();

         return $this->redirectToRoute('event');
       }

       return $this->render('event/new.html.twig', array(
         'form' => $form->createView()
       ));

     }

     /**
      * @Route("/event/edit/{id}", name="editev")
      * Method({"GET", "POST"})
      */
      public function edit(Request $request, $id) {
        $event = new event();
        $event= $this->getDoctrine()->getRepository
        (Event::class)->find($id);
        $form = $this->createFormBuilder($event)
        ->add('name', TextType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('description', TextType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('date', DateType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('location', TextType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('price', TextType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('category', EntityType::class, [
          'class' => 'App\Entity\Category',
        ])
        ->add('save', SubmitType::class, array(
          'label' => 'Update',
          'attr' => array('class' => 'btn')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();

          return $this->redirectToRoute('event');
        }

        return $this->render('event/edit.html.twig', array(
          'form' => $form->createView()
        ));

      }

     /**
      * @Route("/event/{id}", name="show2")
      */
     public function show($id)
     {
       $events= $this->getDoctrine()->getRepository
       (Event::class)->find($id);

         return $this->render('event/show.html.twig', array
         ('events' => $events));
     }

     /**
      * @Route("/event/delete/{id}", name="del2")
      * @Method({"DELETE"})
      */
     public function delete(Request $request, $id){
       $events= $this->getDoctrine()->getRepository
       (Event::class)->find($id);

       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->remove($events);
       $entityManager->flush();

       $response = new Response();
       $response->send();
     }


}
