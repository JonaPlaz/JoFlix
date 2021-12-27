<?php

namespace App\Controller\Front;

use App\Form\ContactType;
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
    public function home(TvShowRepository $tvShowRepository): Response
    {
        $latestTvshows = $tvShowRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render('front/home/home.html.twig', [
            'latestTvshows' => $latestTvshows,
        ]);
    }

    // /**
    //  * @Route("/contact", name="contact")
    //  */
    // public function contact(Request $request)
    // {   
    //     // FQCN = Fully Qualified Class Name
    //     // Le nom complet de la classe avec son namespace
    //     // Soit on l'écrit littéralement, soit on y fait appel 
    //     // en mettant le nom de la classe suivi de ::class

    //     // Pour utiliser un FormType qu'on a créé dans le dossier src/Form
    //     // on appelle la méthode createForm() en lui précisant le FQCN de la classe de formulaire
    //     $form = $this->createForm(ContactType::class);
    //     // $form est un objet de la classe Form de Symfony

    //     // On demande au formulaire d'aller voir les champs reçus en POST dans $request
    //     // de la traiter, de les associer à nos champs et de valider le formulaire et ses données
    //     $form->handleRequest($request);
    //     // Grace à handleRequest, $form a rempli ses propres champs avec les données dans $request
    //     // Ça veut dire que si on affiche le formulaire avec twig, les champs seront préremplis

    //     // On teste si le formulaire est envoyé et s'il est valide
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // On ne va pas envoyer d'email dans cet exercice
    //         // On s'apprete plutot à dump le contenu reçu depuis le formulaire
            
    //         // $form->getData() permet d'obtenir les données associées au formulaire
    //         dd($form->getData());
    //     }

    //     return $this->render('front/home/contact.html.twig', [
    //         // On souhaite envoyer notre formulaire à notre template pour l'afficher
    //         // Twig ne sait pas manipuler un objet de la classe Form,
    //         // cependant il reconnait un objet FormView qu'on peut obtenir avec $form->createView()
    //         'form' => $form->createView(),
    //     ]);
    // }
}
