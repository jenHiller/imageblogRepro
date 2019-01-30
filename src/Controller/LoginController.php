<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    /**
    * @Route("/login", methods={"GET","POST"})
    */
    public function loginAction(Request $request)
    {
        $message = "Logg dich ein!";

        if ($request->isMethod("POST")){
            $user = "";
            $userArray = $request->get("user");

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(["email" => $userArray["email"]]);

            /**
             * @var User $user
             */
            if ($user && $user->getPassword() == md5($userArray["password"])){
                $message = "Du bist eingeloggt ".$user->getEmail();
            }
            else{
                $message = "Falsche Logindaten!";
            }
        }

        return $this->render('login/login.html.twig', [
            "message" => $message
        ]);
    }

    /**
     * @Route("/login/register", methods={"GET","POST"})
     */
    public function registerAction(Request $request)
    {
        if ($request->isMethod("POST")){
            $entityManager = $this->getDoctrine()->getManager();
            $userArray = $request->get("user");
            $user = new User();
            $user->setEmail($userArray["email"]);
            $user->setPassword(md5($userArray["password"]));

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->render('login/register.html.twig', [
            "request" => $request
        ]);
    }

    public function updateAction(Request $request)
    {
        return $this->render('login/update.html.twig', [

        ]);
    }

    public function logoutAction(Request $request)
    {
        return $this->render('login/logout.html.twig', [

        ]);
    }
}