<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends AbstractController
{
    /**
    * @Route("/account", methods={"GET","POST"}, name="account")
    */
    public function accountAction(Request $request)
    {
        $message = "Du bist jetzt eingeloggt!";

        return $this->render('login/account.html.twig', [
            "message" => $message
        ]);
    }
}