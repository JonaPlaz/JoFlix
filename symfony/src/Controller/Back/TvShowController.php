<?php

namespace App\Controller\Back;

use App\Entity\TvShow;
use App\Form\TvShowType;
use App\Repository\TvShowRepository;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tvshow", name="back_tv_show_", requirements={"id"="\d+"})
 */
class TvShowController extends AbstractController
{
  /**
   * @Route("", name="browse")
   */
  public function browse(TvShowRepository $tvShowRepository): Response
  {

    return $this->render('back/tv_show/browse.html.twig', [
      'tvshows' => $tvShowRepository->findAll(),
    ]);
  }

  /**
   * @Route("/{id}", name="read")
   */
  public function read(TvShow $tvshow)
  {
    return $this->render('back/tv_show/read.html.twig', [
      'tvshow' => $tvshow,
    ]);
  }

  /**
   * @Route("/add", name="add")
   */
  public function add(EntityManagerInterface $manager, Request $request, Slugger $slugger)
  {
    $tvShow = new TvShow();

    $form = $this->createForm(TvShowType::class, $tvShow);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $slugger->slugifyTvShow($tvShow);

      $manager->persist($tvShow);
      $manager->flush();

      return $this->redirectToRoute('back_tv_show_browse');
    }

    return $this->render('back/tv_show/add.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/edit/{id}", name="edit")
   */
  public function edit(EntityManagerInterface $manager, Request $request, Slugger $slugger, TvShow $tvShow)
  {
    $this->denyAccessUnlessGranted('EDIT', $tvShow);

    $form = $this->createForm(TvShowType::class, $tvShow);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $slugger->slugifyTvShow($tvShow);

      $manager->flush();

      return $this->redirectToRoute('back_tv_show_browse');
    }

    return $this->render('back/tv_show/edit.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete", methods={"DELETE"})
   */
  public function delete(EntityManagerInterface $manager, TvShow $tvShow)
  {
    $manager->remove($tvShow);
    $manager->flush();

    return $this->redirectToRoute('back_tv_show_browse');
  }
}
