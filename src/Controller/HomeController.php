<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{


    /**
     * HOME test
     */
    public function index()
    {
        $number = random_int(0, 100);
        $url = $this->generateUrl(
            'devtwig',
            ['slug' => 'my-blog-post']
        );

        $this->addFlash(
            'danger',
            'Your changes were saved!'
        );

        return $this->render('home/home.html.twig', [
            'title' => 'Home',
            'number' => $number,
            'url' => $url,

        ]);
    }

    public function login()
    {
        // Invoices

        return $this->render('home/login.html.twig', [
            'title' => 'Login',
        ]);

    }



}