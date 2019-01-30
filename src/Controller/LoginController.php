<?php
// src/Controller/LuckyController.php
namespace App\Controller;

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
            $user = $request->get("user");
            $message = "Du bist eingeloggt ".$user["email"];
        }

        return $this->render('login/login.html.twig', [
            "request" => $request,
            "message" => $message
        ]);
    }

    /**
     * @Route("/login/register", methods={"GET","POST"})
     */
    public function registerAction(Request $request)
    {
        if ($request->isMethod("POST")){
            $user = $request->get("user");


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