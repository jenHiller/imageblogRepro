<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function defaultAction()
    {
        return $this->render('default/default.html.twig', [

        ]);
    }
}