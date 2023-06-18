<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class UtilisateurController extends AbstractController
{
#[Route('/utilisateur', name: 'app_utilisateur', methods: ['GET'])]
public function index(UtilisateurRepository $repository, PaginatorInterface $paginator, Request $request): Response
{
$utilisateurs = $paginator->paginate(
    $repository->findAll(),
    $request->query->getInt('page', 1),
    10
);

return $this->render('pages/utilisateur/index.html.twig', [
    'utilisateurs' => $utilisateurs
]);
}

#[Route('/create/utilisateur', name: 'app_support_user_new', methods: ['GET', 'POST'])]
public function new
(Request $request,
EntityManagerInterface $manager
): Response
{
$utilisateur = new Utilisateur();

$utilisateur->setDateCreation(new \DateTime());

$form = $this->createForm(UtilisateurFormType::class, $utilisateur);


$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $manager->persist($utilisateur);
    $manager->flush();


    $this->addFlash('success',"L'utilisateur a été créé");
}

return $this->render('pages/utilisateur/new.html.twig', [
    'form' => $form->createView()
]);
}

#[Route('/edit/utilisateur/{id}', name: 'app_support_user_edit', methods: ['GET', 'POST'])]
public function edit(
    Request $request,
    EntityManagerInterface $manager,
    Utilisateur $utilisateur
): Response {
    $form = $this->createForm(UtilisateurFormType::class, $utilisateur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($utilisateur);
        $manager->flush();

        $this->addFlash('success', "L'utilisateur a été mis à jour.");

        return $this->redirectToRoute('app_support_user_edit', ['id' => $utilisateur->getId()]);
    }

    return $this->render('pages/utilisateur/edit.html.twig', [
        'form' => $form->createView(),
        'utilisateur' => $utilisateur
    ]);
}

#[Route('/delete/utilisateur/{id}', name: 'app_support_user_delete', methods: ['GET'])]
public function delete(EntityManagerInterface $manager, Utilisateur $utilisateur): Response
{

    if(!$utilisateur) {
        
    $this->addFlash('warning', "L'utilisateur n'a pas été trouvé, vérifiez l'id.");
       return $this->redirectToRoute('app_utilisateur');
    }
    $manager->remove($utilisateur);
    $manager->flush();

    $this->addFlash('danger', "L'utilisateur a été mis à supprimé.");

    return $this->redirectToRoute('app_utilisateur');
}
}