<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    #[Route('/socio', name: 'app_socio')]
    public function index(): Response
    {
        return $this->render('socio/index.html.twig', [
            'controller_name' => 'SocioController',
        ]);
    }
}
