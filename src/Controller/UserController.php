<?php


# src/Controller/UserController.php
namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\UserType;
use App\Entity\User;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType:: class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // $this->redirectToRoute(‘register_sucess’);
        }
        return $this->render('user/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/remove/{id}", name="user_remove")
     */
    public function remove(User $user, EntityManagerInterface $entityManager)
    {
        $videos = $user->get();
        foreach ($videos as $video){
            $video->setUser(null);
        }
        $entityManager->remove($user);
        $entityManager ->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/user/{id}", name="user_id")
     */
    public function user(Request $request, UserRepository $userRepository, int $id)
    {
        // http://localhost/user/42 , then $id = 42;
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname": "firstname"}})
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user)
    {
        // http://localhost/user/christophe , then $user is a User instance with firstname is “christophe” or “ChRisTophE” ...;
    }
}
