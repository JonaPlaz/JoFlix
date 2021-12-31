<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category", name="back_category_", requirements={"id"="\d+"})
 */
class CategoryController extends AbstractController
{
  /**
   * @Route("", name="browse")
   */
  public function browse(CategoryRepository $categoryRepository): Response
  {
    return $this->render('back/category/browse.html.twig', [
      'categories' => $categoryRepository->findAll(),
    ]);
  }

  /**
   * @Route("/add", name="add")
   */
  public function add(EntityManagerInterface $manager, Request $request): Response
  {
    // On crée un nouvel objet Category
    $category = new Category();

    // On précise qu'on associe $category à notre formulaire
    $form = $this->createForm(CategoryType::class, $category);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Si le formulaire a ete envoyé et il est valide, alors $category est rempli avec les informations du formulaire
      // dd($category);

      $manager->persist($category);
      $manager->flush();

      return $this->redirectToRoute('back_category_browse');
    }

    return $this->render('back/category/add.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/edit/{id}", name="edit")
   */
  public function edit(EntityManagerInterface $manager, Request $request, Category $category): Response
  {
    // On précise qu'on associe $category à notre formulaire
    $form = $this->createForm(CategoryType::class, $category);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      $manager->flush();

      return $this->redirectToRoute('back_category_browse');
    }

    return $this->render('back/category/edit.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete")
   */
  public function delete(EntityManagerInterface $manager, Category $category, Request $request)
  {
    // On a créé un token dans les formulaires de suppression dans browse.html.twig
    // On souhaite vérifier que le token reçu est valide
    // On récupère d'abord le token dans $request
    $token = $request->request->get('_token');

    // On demande à symfony de vérifier que le token est valide
    // On lui fournit exactement la chaine de caractères qui a généré le token
    // isCsrfTokenValid() retourne un boolèen, donc on le met dans un if
    if ($this->isCsrfTokenValid('delete_category' . $category->getId(), $token)) {
      // Comme le token est valide on supprime la Category
      $manager->remove($category);
      $manager->flush();
    }

    // Quoiqu'il arrive, on redirige sur la liste des catégories
    return $this->redirectToRoute('back_category_browse');
  }
}
