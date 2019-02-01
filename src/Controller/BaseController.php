<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends AbstractController
{
    public function deleteImage($path){
        if (file_exists($path)){
            unlink($path);
        }
    }

    public function uploadImageAndGetPath($user, $imageFile){
        $now = time();
        $userPath = "blog-images/{$user->getId()}";
        $fileName = "$now.{$imageFile->guessExtension()}";
        $path = $userPath."/".$fileName;

        if (!file_exists($userPath)) {
            mkdir($userPath, 0777, true);
        }
        file_put_contents($path, file_get_contents($imageFile));

        return $path;
    }
}