<?php

namespace App\Controller\Front;

use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\TvShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  /**
   * HomePage + 3 lastest TvShows or Movies
   * 
   * @Route("/", name="home")
   */
  public function home(TvShowRepository $tvShowRepository, CategoryRepository $categoryRepository): Response
  {
    $latestTvshows = $tvShowRepository->findBy([], ['id' => 'DESC'], 3);
    $categories = $categoryRepository->findAll();

    return $this->render('front/home/home.html.twig', [
      'latestTvshows' => $latestTvshows,
      'categories' => $categories,
    ]);
  }

  /**
   * @Route("/contact", name="contact")
   */
  public function contact(Request $request)
  {
    $form = $this->createForm(ContactType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      //  créer un service d'email ?
      dd($form->getData());
    }

    return $this->render('front/home/contact.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
