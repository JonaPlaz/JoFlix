<?php

namespace App\Controller\Back;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/season", name="back_season_", requirements={"id"="\d+"})
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(SeasonRepository $seasonRepository): Response
    {
        return $this->render('back/season/browse.html.twig', [
            'seasons' => $seasonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $manager, Request $request): Response
    {
        $season = new Season();

        $form = $this->createForm(SeasonType::class, $season);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($season);
            $manager->flush();

            return $this->redirectToRoute('back_season_browse');
        }

        return $this->render('back/season/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(EntityManagerInterface $manager, Request $request, Season $season): Response
    {
        $form = $this->createForm(SeasonType::class, $season);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $manager->flush();

            return $this->redirectToRoute('back_season_browse');
        }

        return $this->render('back/season/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, Season $season, Request $request)
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete_season' . $season->getId(), $token)) {

            $manager->remove($season);
            $manager->flush();
        }

        return $this->redirectToRoute('back_season_browse');
    }
}
