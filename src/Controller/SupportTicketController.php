<?php

namespace App\Controller;

use App\Entity\SupportTicket;
use App\Form\SupportTicketFormType;
use App\Form\SupportTicketType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SupportTicketRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SupportTicketController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param SupportTicketRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/support/ticket', name: 'app_support_ticket', methods: ['GET'])]
    public function index(SupportTicketRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $supportTickets = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/support_ticket/index.html.twig', [
            'supportTickets' => $supportTickets
        ]);
    }

    #[Route('/create/support/ticket', name: 'app_support_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $supportTicket = new SupportTicket();

        $supportTicket->setDateCreation(new \DateTime());

        $form =  $this->createForm(SupportTicketType::class, $supportTicket);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }
        return $this->render('pages/support_ticket/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
#[Route('/edit/support/ticket/{id}', name: 'app_support_ticket_edit', methods: ['GET', 'POST'])]
public function edit(SupportTicket $supportTicket, Request $request, EntityManagerInterface $manager): Response
{
$form = $this->createForm(SupportTicketFormType::class, $supportTicket);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $manager->persist($supportTicket);
    $manager->flush();

    $this->addFlash('success', "Le ticket a été mis à jour.");
}

return $this->render('pages/support_ticket/edit.html.twig', [
    'form' => $form->createView()
]);
}

#[Route('/delete/support/ticket/{id}', name: 'app_support_ticket_delete', methods: ['GET'])]
public function delete(EntityManagerInterface $manager, SupportTicket $supportTicket): Response
{

    if(!$supportTicket) {
        
    $this->addFlash('warning', "Le ticket n'a pas été trouvé, vérifiez l'id.");
       return $this->redirectToRoute('app_support_ticket');
    }
    $manager->remove($supportTicket);
    $manager->flush();

    $this->addFlash('danger', "Le ticket a été mis à supprimé.");

    return $this->redirectToRoute('app_support_ticket');
}
}

