<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    //own

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {

        $form=$this->createFormBuilder()
            ->add('email')
            ->add('password',PasswordType::class)
            ->add('register',SubmitType::class,[
                'attr'=>['class'=>'btn btn-success float-right']
            ])

            //to get the form outof this we need to do the below things
            ->getForm()
        ;
        $form->handleRequest($request);
        $user1=new User();
        if($form->isSubmitted()){
             $data=$form->getData();
             //dump($data);
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
            //dump($user);die;
$superadmin="superadmin";
           // $password=$user->getPassword();
           // $encoded = $passwordEncoder->encodePassword($user1,$data['password']);
            //$user->setPassword($encoded);
            //$user1=new User();
            //$encodedPassword = $passwordEncoder->encodePassword($user1,$password1);
             // var_dump($encoded);

            $role=$user->getRole();
            if($user==null)
            {
                    echo "wrong user";die;
            }
            elseif($superadmin!=$data['password'] )
            {
                echo "wrong password";die;
            }
            elseif($role!='admin')
            {
                echo "you are not admin";die;
            }
            else
            {
                return $this->redirect($this->generateUrl('admincreate'));
            }

            //    $user=new User();
            //   $user->setUsername($data['username']);
            //   $user->setPassword($passwordEncoder->encodePassword($user,$data['password']));
            //   $em=$this->getDoctrine()->getManager();
            //  $em->persist($user);
            //  $em->flush();
            // return $this->redirect($this->generateUrl('app_login'));
        }
        return $this->render('admin/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }





    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
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

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
//own
    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//$this->getDoctrine()->getManager()->flush();

            $entityManager = $this->getDoctrine()->getManager();

// Encoding the Password
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

// $entityManager->persist($user);
            $entityManager->flush();

           // return $this->redirectToRoute('user_index');
            if($user->getRole()=='teacher')
                return $this->redirectToRoute('teacher_dashboard');
            else
                return $this->redirectToRoute('student_dashboard');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/teacher/dashboard", name="teacher_dashboard", methods={"GET"})
     */
    public function tdash(UserRepository $userRepository):Response
    {
        return $this->render('teacherdashboard/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin/dashboard", name="admin_dashboard", methods={"GET"})
     */
    public function admindash(UserRepository $userRepository):Response
    {
        return $this->render('admindashboard/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }
    //own
    /**
     * @Route("/realadmin/dashboard", name="realadmin_dashboard", methods={"GET"})
     */
    public function realadmindash(UserRepository $userRepository):Response
    {
        return $this->render('admindashboard/index2.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/student/dashboard", name="student_dashboard", methods={"GET"})
     */
    public function sdash(UserRepository $userRepository):Response
    {
        return $this->render('studentdashboard/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }


    //own





}