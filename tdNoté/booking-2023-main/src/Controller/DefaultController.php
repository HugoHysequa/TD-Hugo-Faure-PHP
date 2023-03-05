<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ConfigurationType;
use App\Repository\SeatRepository;
use App\Repository\ConfigurationRepository;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ConfigurationRepository $configurationRepository, SeatRepository $seatRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'configuration' => $configurationRepository->findAll(),
            'places' => $seatRepository->find(1)
        ]);
    }
}
