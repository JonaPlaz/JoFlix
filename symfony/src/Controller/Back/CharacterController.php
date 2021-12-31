<?php

namespace App\Controller\Back;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/character", name="back_character_", requirements={"id"="\d+"})
 */
class CharacterController extends AbstractController
{
  private $manager;

  /**
   * On injecter le manager dans le controleur
   */
  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  /**
   * @Route("", name="browse")
   */
  public function browse(CharacterRepository $characterRepository): Response
  {
    return $this->render('back/character/browse.html.twig', [
      'characters' => $characterRepository->findAll(),
    ]);
  }

  /**
   * @Route("/{id}", name="read")
   */
  public function read(Character $character)
  {
    return $this->render('back/character/read.html.twig', [
      'character' => $character,
    ]);
  }

  /**
   * @Route("/add", name="add")
   */
  public function add(Request $request)
  {
    $character = new Character();

    $form = $this->createForm(CharacterType::class, $character);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->manager->persist($character);
      $this->manager->flush();

      return $this->redirectToRoute('back_character_browse');
    }

    return $this->render('back/character/add.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/edit/{id}", name="edit")
   */
  public function edit(Request $request, Character $character)
  {
    $form = $this->createForm(CharacterType::class, $character);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->manager->flush();

      return $this->redirectToRoute('back_character_browse');
    }

    return $this->render('back/character/edit.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete")
   */
  public function delete(Character $character, Request $request)
  {
    $token = $request->request->get('_token');

    if ($this->isCsrfTokenValid('delete_character' . $character->getId(), $token)) {
      $this->manager->remove($character);
      $this->manager->flush();
    }

    return $this->redirectToRoute('back_character_browse');
  }
}
