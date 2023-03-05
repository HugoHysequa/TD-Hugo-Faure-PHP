<?php

namespace App\Controller;

use App\Entity\Show;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;

#[Route('/show')]
class ShowController extends AbstractController
{
    #[Route('/', name: 'app_show_index', methods: ['GET'])]
    public function index(Request $request, ShowRepository $showRepository, PaginatorInterface $paginator): Response
    {
        $date = new DateTime();
        $results = $showRepository->createQueryBuilder('s')
        ->where('s.date_end > :query')
        ->setParameter('query', $date)
        ->orderBy('s.date_start', 'DESC')
        ->getQuery()
        ->getResult();



        $spectacles = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('show/index.html.twig', [
            'shows' => $spectacles,
        ]);
    }

    #[Route('/map', name: 'app_show_map', methods: ['GET'])]
    public function map()
    {
        return $this->render('show/map.html.twig');
    }
}
