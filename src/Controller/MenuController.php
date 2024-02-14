<?php

namespace App\Controller;

use App\Repository\OutilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends  AbstractController
{


    /**
     * @Route("/menu", name="app_menu")
     */
    public function menu(OutilRepository $outilRepository): Response
    {
        $outils = $outilRepository->findAll();

        return $this->render('inc/navH.html.twig', [
            'listoutils' => $outils
        ]);
    }
}