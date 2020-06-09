<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createFormBuilder()
            ->add('pseudo', null, [
                'required' => true,
                'attr' => [
                    'class' => 'text-center'
                ]
            ])
            ->add('email', EmailType::class)
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => ['label' => 'Confirmer',
                    'attr' => [
                        'class' => 'form-control'
                    ]],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = new Utilisateur();
            $user->setPseudo($data['pseudo']);
            $user->setEmail($data['email']);
            $user->setMdp(
                $passwordEncoder->encodePassword($user, $data['mdp'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl("app_login"));
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);


    }
}
