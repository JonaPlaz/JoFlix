<?php

namespace App\Controller\Front;

use App\Repository\TvShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
  /**
   * 
   * Display search result
   * 
   * @Route("/search", name="search_results")
   */
  public function results(Request $request, TvShowRepository $tvShowRepository): Response
  {
    $searchTerm = $request->get('search');

    $results = $tvShowRepository->findAllBySearchTerm($searchTerm);

    return $this->render('front/search/results.html.twig', [
      'results' => $results,
      'searchTerm' => $searchTerm
    ]);
  }
}
