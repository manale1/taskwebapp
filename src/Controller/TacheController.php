<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheFormType;
use App\Form\UpdateTaskType;
use App\Repository\OutilRepository;
use App\Repository\StatutRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    /**
     * @Route("/addtask/{id}",name="app_addtask")
     */
    public function addTask(int $id,EntityManagerInterface $entityManager,Request $request,
                            StatutRepository $statutRepository,OutilRepository $outilRepository):Response
    {
        $tache = new Tache();
        $formtache = $this->createForm(TacheFormType::class,$tache);
        $formtache->handleRequest($request);
        $statut = $statutRepository->find(1);
        $outil = $outilRepository->find($id);
        $formOutil=$outilRepository->JsonToFormHtml($outil->getParametres());
        if($formtache->isSubmitted() && $formtache->isValid())
        {
            $employe = $tache->getIdEmploye();
            $client = $tache->getIdClient();
            $parametres = [
                'Designation' => $tache->getDesignation(),
                'Date de debut' => $tache->getDateDebut(),
                'Date fin ' => $tache->getDateFin(),
                'Outil' => $outil->getNom(),
                'Employe' => ['nom' => $employe->getNom(),'prenom' => $employe->getPrenom() , 'email' => $employe->getEmail()],
                'Client' => ['nom' => $client->getNom(),'prenom' => $client->getPrenom() , 'email' => $client->getEmail()],
                'Satatut' => $statut->getLibelle()
                    ];
            $tache->setIdStatut($statut);
            $tache->setIdOutil($outil);
            $tache->setParametres($parametres);
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('app_m');
        }
        return $this->render('addTask.html.twig',
        ['formtache' => $formtache->createView(),
            'formOutil' => $formOutil
        ]);
    }
    /**
     * @Route("/listtaches",name="app_listtasks")
     */
    public function listTasks(TacheRepository $tacheRepository):Response
    {
        $listtasks = $tacheRepository->findAll();
        return $this->render('listTaches.html.twig',[
            'listtaches' => $listtasks
        ]);
    }
    /**
     * @Route("/updatetache/{id}",name="app_updatetache")
     */
    public function updateTask(int $id,TacheRepository $tacheRepository,EntityManagerInterface $entityManager,
                                Request $request,StatutRepository $statutRepository):Response
    {
       $tache = $tacheRepository->find($id);
       $status = $tache->getIdStatut();
       $formTache = $this->createForm(UpdateTaskType::class,$tache);
       $formTache->handleRequest($request);
       if($formTache->isSubmitted() && $formTache->isValid())
       {
           if($status->getId() == 3)
           {
               $statusT = $statutRepository->find(4);
               $dateFin = new \DateTime();

           }
           $tache->setIdStatut($statusT);
           $tache->setDateFin($dateFin);
           $entityManager->persist($tache);
           $entityManager->flush();
           return  $this->redirectToRoute('app_listtasks');
       }
        return $this->render('updateTask.html.twig',[
            'formtache' => $formTache->createView()
        ]);
    }
    /**
     * @Route("/deletetache/{id}",name="app_deletetache")
     */
    public function deleteTask(int $id,TacheRepository $tacheRepository):Response
    {
        $tache = $tacheRepository->find($id);
        $tacheRepository->remove($tache,true);
        return $this->redirectToRoute('app_listtasks');
    }

}