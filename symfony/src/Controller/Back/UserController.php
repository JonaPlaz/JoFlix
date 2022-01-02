<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="back_user_", requirements={"id"="\d+"})
 */
class UserController extends AbstractController
{
  /**
   * @Route("/", name="browse", methods={"GET"})
   */
  public function browse(UserRepository $userRepository): Response
  {
    return $this->render('back/user/browse.html.twig', [
      'users' => $userRepository->findAll(),
    ]);
  }

  /**
   * @Route("/add", name="add", methods={"GET","POST"})
   */
  public function new(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
  {
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $password = $form->get('password')->getData();
      $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
      $user->setPassword($hashedPassword);

      $manager->persist($user);
      $manager->flush();

      return $this->redirectToRoute('back_user_browse', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('back/user/add.html.twig', [
      'user' => $user,
      'form' => $form,
    ]);
  }

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(User $user): Response
  {
    return $this->render('back/user/read.html.twig', [
      'user' => $user,
    ]);
  }

  /**
   * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
   */
  public function edit(EntityManagerInterface $manager, Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
  {
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      $password = $form->get('password')->getData();
    
      if ($password != null) {
       
        $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
      }

      $manager->flush();

      return $this->redirectToRoute('back_user_browse', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('back/user/edit.html.twig', [
      'user' => $user,
      'form' => $form,
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete")
   */
  public function delete(EntityManagerInterface $manager, Request $request, User $user): Response
  {
    if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
      
      $manager->remove($user);
      $manager->flush();
    }

    return $this->redirectToRoute('back_user_browse', [], Response::HTTP_SEE_OTHER);
  }
}
