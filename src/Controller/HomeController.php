<?php

namespace App\Controller;

use App\Repository\OutilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/main",name="app_m")
     */
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

}
