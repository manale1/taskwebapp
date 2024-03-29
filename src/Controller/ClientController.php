<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/addclient", name="app_addclient")
     */
    public function addClient(EntityManagerInterface $entityManager,Request $request) : Response
    {
        $client = new Client();
        $formClient = $this->createForm(ClientFormType::class,$client);
        $formClient->handleRequest($request);
        if($formClient->isSubmitted() && $formClient->isValid())
        {
            $this->addFlash('success', 'This client is successfully added');
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('app_listclients');
        }
        return $this->render('addclient.html.twig',[
            'formclient' => $formClient->createView()
        ]);
    }
    /**
     * @Route("/updateclient/{id}", name="app_updateclient")
     */
    public function updateClient(int $id,EntityManagerInterface $entityManager,
                                 Request $request,ClientRepository $clientRepository):Response
    {
        $client = $clientRepository->find($id);
        $formClient = $this->createForm(ClientFormType::class,$client);
        $formClient->handleRequest($request);
        if($formClient->isSubmitted() && $formClient->isValid())
        {
            $this->addFlash('success', 'This client is successfully updated');
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('app_m');
        }
        return $this->render('updateclient.html.twig',[
            'formclient' => $formClient->createView()
        ]);
    }
    /**
     * @Route("/listclients", name="app_listclients")
     */
    public function listClients(ClientRepository $clientRepository):Response
    {
        $clients = $clientRepository->findAll();
        return $this->render('listClients.html.twig',[
            'clients' => $clients
        ]);
    }
    /**
     * @Route("/deleteclient/{id}", name="app_deleteclient")
     */
    public function deleteClient(int $id,ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);
        if($client)
        {
            $this->addFlash('success', 'This client is successfully deleted');
            $clientRepository->remove($client,true);
        }
        else
        {
            $this->addFlash('danger', 'Error');
        }
        return $this->redirectToRoute('app_listclients');
    }
    /**
     * @Route ("/finbyemailc",name ="app_finbyemailc")
     */
    public function finByEmail(Request $request,ClientRepository $clientRepository) :Response
    {
        $email = $request->request->get('email');

        $client = $clientRepository->findByEmail($email);

        return $this->render('listClients.html.twig',['client' => $client]);
    }
}