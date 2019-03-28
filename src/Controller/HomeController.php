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
        $number = random_int(0, 100);
        $url = $this->generateUrl(
            'devtwig',
            ['slug' => 'test1']
        );

        return $this->render('home/home.html.twig', [
            'title' => 'Home1',
            'number' => $number,
            'url' => $url,

        ]);
    }

    public function login()
    {
        return $this->render('home/login.html.twig', [
            'title' => 'Login',
        ]);
    }

}