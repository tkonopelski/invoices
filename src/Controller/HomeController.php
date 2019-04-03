<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * HOME
     *
     */
    public function index()
    {
        return $this->render('home/home.html.twig', [
            'title' => 'Home1',
        ]);
    }


    public function login()
    {
        return $this->render('home/login.html.twig', [
            'title' => 'Login',
        ]);
    }

}