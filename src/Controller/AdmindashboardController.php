<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminType;


use App\Form\RealadminType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AdmindashboardController extends AbstractController
{
    /**
     * @Route("/admindashboard", name="admindashboard")
     */
    public function index()
    {
        return $this->render('admindashboard/index.html.twig', [
            'controller_name' => 'AdmindashboardController',
        ]);
    }
    /**
     * @Route("/admin/dashboard", name="admincreate")
     */
    public function adash(UserRepository $userRepository):Response
    {
        return $this->render('admindashboard/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newadmin", name="admin_new", methods={"GET","POST"})
     */

    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//var_dump($user);die;
            $entityManager = $this->getDoctrine()->getManager();

// Encoding the Password
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/realnewadmin", name="realadmin_new", methods={"GET","POST"})
     */

    public function realnew(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RealadminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//var_dump($user);die;
            $entityManager = $this->getDoctrine()->getManager();

// Encoding the Password
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('realadmin_dashboard');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }










    public function admin_new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//var_dump($user);die;
            $entityManager = $this->getDoctrine()->getManager();

// Encoding the Password
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




}
