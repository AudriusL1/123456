<?php

namespace App\Controller;

use App\Entity\Category;
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

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="category")
     */
    public function index()
    {
      $categories= $this->getDoctrine()->getRepository
      (Category::class)->findAll();

      $user = $this->get('security.token_storage')->getToken()->getUser();

      $role = $user->getRole();
      if($role == 1)
      {
        return $this->render('category/index.html.twig', array
        ('categories' => $categories));
      }
        return $this->render('category/indexuser.html.twig', array
        ('categories' => $categories, 'userid' => $user));
    }

    /**
     * @Route("/categories/new", name="newcategory")
     * Method({"GET", "POST"})
     */
     public function new(Request $request) {

       $user = $this->get('security.token_storage')->getToken()->getUser();

       $role = $user->getRole();
       if($role == 1){
       $category = new category();
       $form = $this->createFormBuilder($category)
       ->add('name', TextType::class, array('attr' =>
       array('class' => 'form-control')))
       ->add('save', SubmitType::class, array(
         'label' => 'Create',
         'attr' => array('class' => 'btn')))
       ->getForm();

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
         $category = $form->getData();

         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($category);
         $entityManager->flush();

         return $this->redirectToRoute('category');
       }

       return $this->render('/category/new.html.twig', array(
         'form' => $form->createView()
       ));
      }
      return $this->redirectToRoute('category');
     }

     /**
      * @Route("/categories/sub/{id}", name="subscribe")
      * Method({"GET", "POST"})
      */
      public function subscribe($id) {
        $sub = new category();
        $sub = $this->getDoctrine()->getRepository
        (category::class)->find($id);
        $user = $this->get('security.token_storage')
        ->getToken()->getUser();

          $sub->addSub($user);

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($sub);
          $entityManager->flush();

          return $this->redirectToRoute('category');
        }

        /**
         * @Route("/categories/unsub/{id}", name="unsubscribe")
         * Method({"GET", "POST"})
         */
         public function unsubscribe($id) {
           $sub = new category();
           $sub = $this->getDoctrine()->getRepository
           (category::class)->find($id);
           $user = $this->get('security.token_storage')
           ->getToken()->getUser();

             $sub->removeSub($user);

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($sub);
             $entityManager->flush();

             return $this->redirectToRoute('category');
           }

     /**
      * @Route("/categories/edit/{id}", name="editcat")
      * Method({"GET", "POST"})
      */
      public function edit(Request $request, $id) {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $role = $user->getRole();
        if($role == 1){
        $category = new category();
        $category = $this->getDoctrine()->getRepository
        (category::class)->find($id);
        $form = $this->createFormBuilder($category)
        ->add('name', TextType::class, array('attr' =>
        array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
          'label' => 'Update',
          'attr' => array('class' => 'btn')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();

          return $this->redirectToRoute('category');
        }

        return $this->render('/category/edit.html.twig', array(
          'form' => $form->createView()
        ));
        }
        return $this->redirectToRoute('category');
      }

      /**
       * @Route("/categories/delete/{id}", name="del3")
       * @Method({"DELETE"})
       */
      public function delete(Request $request, $id){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $role = $user->getRole();
        if($role == 1){
        $category= $this->getDoctrine()->getRepository
        (category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        $response = new Response();
        $response->send();
      }
        return $this->redirectToRoute('category');
      }



}
