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
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $role = $user->getRole();

        if($role == 1)
        {
          return $this->render('profile/index.html.twig', array
          ('user' => $user));
        }

        return $this->render('profile/indexuser.html.twig', array
        ('user' => $user));

      //return $this->render('profile/index.html.twig');
    }

}
