<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ShowRepository;
use App\Entity\Seat;
use App\Form\GenerateSeatsFormType;
use App\Repository\SeatRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Show;
use App\Form\ShowType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConfigurationRepository;
use App\Form\ConfigurationType;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/seat', name: 'app_seat_index', methods: ['GET', 'POST'])]
    public function index(Request $request, SeatRepository $seatRepository): Response
    {
        $config = $seatRepository->find(1);
        $form = $this->createForm(GenerateSeatsFormType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seatRepository->save($config, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seat/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/configuration', name: 'configuration', methods: ['GET', 'POST'])]
    public function configuration(Request $request, ConfigurationRepository $configurationRepository): Response
    {
        $config = $configurationRepository->find(1);
        $form = $this->createForm(ConfigurationType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configurationRepository->save($config, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('default/configuration.html.twig', [
            'config' => $config,
            'form' => $form,
        ]);
    }
    

    #[Route('/new', name: 'app_show_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShowRepository $showRepository): Response
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $results = $showRepository->createQueryBuilder('s')
            ->where('s.date_end > :query AND s.date_start < :query2')
            ->setParameter('query', $form->getData()->getDateStart())
            ->setParameter('query2', $form->getData()->getDateEnd())
            ->getQuery()
            ->getResult();
            if(!$results && $form->getData()->getDateEnd() > $form->getData()->getDateStart()){
            $showRepository->save($show, true);

            return $this->redirectToRoute('app_show_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
        return $this->renderForm('show/new.html.twig', [
            'show' => $show,
            'form' => $form,
            'erreur' => 'Un spectacle est déjà prévu à cette date ou vos horaires sont incorrects',
        ]);
        }
        }

        return $this->renderForm('show/new.html.twig', [
            'show' => $show,
            'form' => $form,
            'erreur' => null,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_show_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Show $show, ShowRepository $showRepository): Response
    {
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $showRepository->save($show, true);
    
                return $this->redirectToRoute('app_show_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('show/edit.html.twig', [
            'show' => $show,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_show_delete', methods: ['POST'])]
    public function delete(Request $request, Show $show, ShowRepository $showRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $showRepository->remove($show, true);
        }

        return $this->redirectToRoute('app_show_index', [], Response::HTTP_SEE_OTHER);
    }
}
