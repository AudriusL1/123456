<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\RegistrationFormType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    /**
     * @Route("/changePassword", name="changePassword")
     * Method({"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $password = new User();

        $this->get('security.token_storage')
            ->getToken()->getUser();
        $id = $this->get('security.token_storage')
            ->getToken()->getUser()->getId();


        $password = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder($password)
            ->add('password', RepeatedType::class, [

                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'New Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            /*  ->add('password', TextType::class, array('attr' =>
                  array('class' => 'form-control')))*/

            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $password->setPassword(
                $passwordEncoder->encodePassword(
                    $password,
                    $form->get('password')->getData()
                )
            );



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/changePassword.html.twig', array(
            'form' => $form->createView()
        ));

    }

}
