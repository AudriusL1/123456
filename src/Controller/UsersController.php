<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
      $users= $this->getDoctrine()->getRepository
      (User::class)->findAll();

        return $this->render('users/index.html.twig', array
        ('users' => $users));
    }

    /**
     * @Route("/users/{id}", name="show")
     */
    public function show($id)
    {
      $users= $this->getDoctrine()->getRepository
      (User::class)->find($id);

        return $this->render('users/show.html.twig', array
        ('users' => $users));
    }

    /**
     * @Route("/users/rolechange/{id}", name="rolechange")
     */
     public function change($id) {

       $user= $this->getDoctrine()->getRepository
       (User::class)->find($id);
       if($user->getRole() == 0){
       $user->setRole(1);
       }
       elseif ($user->getRole() == 1) {
         $user->setRole(0);
       }

         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($user);
         $entityManager->flush();

         return $this->redirectToRoute('users');
       }

    /**
     * @Route("/users/delete/{id}", name="del")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id){
      $users= $this->getDoctrine()->getRepository
      (User::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($users);
      $entityManager->flush();

      $response = new Response();
      $response->send();
    }

    /**
     * @Route("/menu", name="menu")
     */
    public function menu()
    {
        return $this->render('users/menu.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }


}
