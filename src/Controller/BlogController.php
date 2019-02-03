<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use App\Entity\Images;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends BaseController
{
    /**
    * @Route("/blog/", methods={"GET","POST"}, name="blog")
    */
    public function homeAction(Request $request)
    {
        $images = $this->getDoctrine()
            ->getRepository(Images::class)
            ->findAll();

        return $this->render('blog/home.html.twig', [
            "images" => $images
        ]);
    }

    /**
     * @Route("/blog/my-images", methods={"GET","POST"}, name="blog-my-images")
     */
    public function myImagesAction(Request $request)
    {
        if ($request->isMethod("POST")){
            /**
             * @var User $user
             */
            $user = $this->getUser();
            $now = time();
            $imageFile = $request->files->get("image");
            $userPath = "blog-images/{$user->getId()}";
            $fileName = "$now.{$imageFile->guessExtension()}";
            $path = $userPath."/".$fileName;

            if (!file_exists($userPath)) {
                mkdir($userPath, 0777, true);
            }
            file_put_contents($path, file_get_contents($imageFile));

            $image = new Images();
            $image->setPath($path);
            $image->setUser($user->getId());
            $image->setUserEmail($user->getEmail());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();
        }

        /**
         * @var User $user
         */
        $user = $this->getUser();
        $images = $this->getDoctrine()
            ->getRepository(Images::class)
            ->findBy(["user" => $user->getId()]);

        return $this->render('blog/my-images.html.twig', [
            "images" => $images
        ]);
    }

    /**
     * @Route("/blog/my-images/edit/{id}", methods={"GET","POST"}, name="image-edit")
     */
    public function imageEditAction($id, Request $request)
    {
        /**
         * @var Images $image
         */
        $image = $this->getDoctrine()
            ->getRepository(Images::class)
            ->findOneBy(["id" => $id]);



        if ($request->isMethod("POST")){
            /**
             * @var User $user
             */
            $user = $this->getUser();

            if ($image && $image->getUser() == $user->getId()) {
                $imageFile = $request->files->get("image");

                // altes Bild löschen
                $this->deleteImage($image->getPath());

                // neues Bild hochladen
                $path = $this->uploadImageAndGetPath($user, $imageFile);
                $image->setPath($path);

                $entityManager = $this->getDoctrine()->getManager();
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($image);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
            }
        }

        return $this->render('blog/image-edit.html.twig', [
            "image" => $image
        ]);
    }



    /**
     * @Route("/blog/my-images/delete", methods={"POST"}, name="image-delete")
     */
    public function imageDeleteAction(Request $request)
    {
        $user = $this->getUser();
        $id = $request->get('id');

        $image = $this->getDoctrine()
            ->getRepository(Images::class)
            ->findOneBy(["id" => $id]);

        if ($image && $image->getUser() == $user->getId()) {
            $this->deleteImage($image->getPath());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return new JsonResponse("Delete Abgeschlossen");
    }
}