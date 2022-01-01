<?php

namespace App\Controller\Front;

use App\Entity\TvShow;
use App\Repository\TvShowRepository;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tvshow", name="tvshow_")
 */
class TvShowController extends AbstractController
{
  /**
   * Display all TvShows
   * 
   * @Route("", name="browse")
   */
  public function browse(TvShowRepository $tvShowRepository): Response
  {
    return $this->render('front/tv_show/browse.html.twig', [
      'tvShows' => $tvShowRepository->findAll(),
    ]);
  }

  /**
   * Display TvShow Details
   * 
   * @Route("/{id}", name="read", requirements={"id"="\d+"})
   *
   * @return Response
   */
  public function read(Slugger $slugger, EntityManagerInterface $manager, TvShow $tvShow): Response
  {
    if ($tvShow->getSlug() === null) {
      $slugger->slugifyTvShow($tvShow);
      $manager->flush();
    }

    // On redirige sur la route /tvshow/{slug}
    return $this->redirectToRoute('tvshow_read_slug', [
      'slug' => $tvShow->getSlug(),
    ]);

    return $this->render('front/tv_show/read.html.twig', [
      'tvShow' => $tvShow,
    ]);
  }

  /**
   * @Route("/{slug}", name="read_slug")
   *
   * @return Response
   */
  public function readSlug(TvShow $tvShow): Response
  {
    return $this->render('front/tv_show/read.html.twig', [
      'tvShow' => $tvShow
    ]);
  }
}
