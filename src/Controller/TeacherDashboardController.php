<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherDashboardController extends AbstractController
{
    /**
     * @Route("/teacher", name="teacher")
     */
    public function index()
    {
        return $this->render('teacherdashboard/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }


    /**
     * @Route("/teacher/list", name="studentlist",)
     */
    public function studentlist(UserRepository $userRepository):Response
    {
        return $this->render('teacherdashboard/show.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }
}