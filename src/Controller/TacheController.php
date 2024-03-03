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
            $data = $request->request->all();
            $parametres = [
                'Date fin ' => $tache->getDateFin(),
                'Outil' => $outil->getNom(),
                'Employe' => ['nom' => $employe->getNom(),'prenom' => $employe->getPrenom() , 'email' => $employe->getEmail()],
                'Client' => ['nom' => $client->getNom(),'prenom' => $client->getPrenom() , 'email' => $client->getEmail()],
                'Satatut' => $statut->getLibelle(),
                'ParamOutil' => $data
                    ];
            $this->addFlash('success', 'This task is successfully Added');
            $tache->setIdStatut($statut);
            $tache->setIdOutil($outil);
            $tache->setParametres($parametres);
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('app_listtasks');
        }
        return $this->render('addTask.html.twig',
        ['formtache' => $formtache->createView(),
            'formOutil' => $formOutil,
            'idoutil' => $id
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
     * @Route("/convertjson/{id}",name="app_convertjson")
     */
    public function convertToJson(int $id,TacheRepository $tacheRepository):Response
    {
        $tache = $tacheRepository->find($id);
        $parametres = $tache->getParametres();
        return $this->render('convertjson.html.twig',[
            'paramjson' => $parametres
        ]);
    }
    /**
     * @Route("/updatetache/{id}",name="app_updatetache")
     */
    public function updateTask(int $id,TacheRepository $tacheRepository,EntityManagerInterface $entityManager,
                                Request $request,StatutRepository $statutRepository,OutilRepository $outilRepository):Response
    {
       $tache = $tacheRepository->find($id);
        $outil = $tache->getIdOutil();
        $formOutil = $outilRepository->JsonToFormHtml($outil->getParametres());
       $formTache = $this->createForm(UpdateTaskType::class,$tache);
       $formTache->handleRequest($request);
       if($formTache->isSubmitted() && $formTache->isValid())
       {
           $statut = $tache->getIdStatut();
           $employe = $tache->getIdEmploye();
           $client = $tache->getIdClient();
           $data = $request->request->all();
           if($statut->getId() == 3)
           {
               $statusT = $statutRepository->find(4);
               $dateFin = new \DateTime();
               $tache->setIdStatut($statusT);
               $tache->setDateFin($dateFin);
               $parametres = [
                   'Date fin ' => $dateFin,
                   'Outil' => $outil->getNom(),
                   'Employe' => ['nom' => $employe->getNom(),'prenom' => $employe->getPrenom() , 'email' => $employe->getEmail()],
                   'Client' => ['nom' => $client->getNom(),'prenom' => $client->getPrenom() , 'email' => $client->getEmail()],
                   'Satatut' => $statusT->getLibelle(),
                   'ParamOutil' => $data
               ];
           }
           else
           {
               $parametres = [
                   'Date fin ' => $tache->getDateFin(),
                   'Outil' => $outil->getNom(),
                   'Employe' => ['nom' => $employe->getNom(),'prenom' => $employe->getPrenom() , 'email' => $employe->getEmail()],
                   'Client' => ['nom' => $client->getNom(),'prenom' => $client->getPrenom() , 'email' => $client->getEmail()],
                   'Satatut' => $statut->getLibelle(),
                   'ParamOutil' => $data
               ];
           }
           $tache->setParametres($parametres);
           $this->addFlash('success', 'This task is successfully updated');
           $entityManager->persist($tache);
           $entityManager->flush();
           return  $this->redirectToRoute('app_listtasks');
       }
        return $this->render('updateTask.html.twig',[
            'formtache' => $formTache->createView(),
            'formOutil' => $formOutil
        ]);
    }
    /**
     * @Route("/deletetache/{id}",name="app_deletetache")
     */
    public function deleteTask(int $id,TacheRepository $tacheRepository):Response
    {
        $tache = $tacheRepository->find($id);
        if($tache)
        {
            $tacheRepository->remove($tache,true);
            $this->addFlash('success', 'This task is successfully deleted');
        }
       else
       {
           $this->addFlash('danger', 'Error This task does not exist');
       }
        return $this->redirectToRoute('app_listtasks');
    }
    /**
     * @Route("/finbydate",name="app_findbydate")
     */
    public function findByDate(TacheRepository $tacheRepository,Request $request):Response
    {
        $dateDebut = $request->request->get('dated');
        $dateFin = $request->request->get('datef');

        $taches = $tacheRepository->findByDate($dateDebut,$dateFin);

        return $this->render('listTaches.html.twig',['taches' => $taches]);
    }
    /**
     * @Route("/finbydesignation",name="app_finbydesignation")
     */
    public function finByDesignation(TacheRepository $tacheRepository,Request $request):Response
    {
        $designation = $request->request->get('designation');


        $taches = $tacheRepository->findByDesignation($designation);

        return $this->render('listTaches.html.twig',['taches' => $taches]);
    }
    /**
     * @Route("/taskrealized",name="app_taskrealized")
     */
    public function taskRealized(TacheRepository $tacheRepository,Request $request):Response
    {

        $taskrealized = $tacheRepository->taskRealized();

        return $this->render('taskrealized.html.twig',['taskrealized' => $taskrealized]);
    }
    /**
     * @Route("/tasktoberealized",name="app_tasktoberealized")
     */
    public function taskToBeRealized(TacheRepository $tacheRepository,Request $request):Response
    {

        $tasktoberealized = $tacheRepository->taskToBeRealized();

        return $this->render('tasktoberealized.html.twig',['tasktoberealized' => $tasktoberealized]);
    }
    /**
     * @Route("/taskclosed",name="app_taskclosed")
     */
    public function taskClosed(TacheRepository $tacheRepository,Request $request):Response
    {

        $taskclosed = $tacheRepository->taskClosed();

        return $this->render('taskclosed.html.twig',['taskclosed' => $taskclosed]);
    }


}