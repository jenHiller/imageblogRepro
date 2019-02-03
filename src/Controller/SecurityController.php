<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/login/register", methods={"GET","POST"}, name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $message = "Hier kannst Du Dich registrieren. Danach wirst Du direkt zum Login weitergeleitet.";

        if ($request->isMethod("POST")){
            // Step 1: Schauen ob der User schon vorhanden ist
            $entityManager = $this->getDoctrine()->getManager();
            $userArray = $request->get("user");

            $duplicate_acc = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(["email" => $userArray["email"]]);

            if ($duplicate_acc) {
                $message = "Account existiert bereits.";
            }
            else{
                // Step 2: Falls user nicht vorhanden ist ihn anlegen
                $user = new User();
                $user->setEmail($userArray["email"]);
                $user->setPassword( $passwordEncoder->encodePassword(
                    $user,
                    $userArray["password"]
                ));

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('security/register.html.twig', [
            "message" => $message
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }
}
