<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Projet;
use App\Form\ProjectFormType;
use App\Repository\EtatRepository;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class ProjetController extends AbstractController
{

    /**
     * @Route ("/addproject",name="app_addproject")
     */
    public function addProject(EntityManagerInterface $entityManager,Request $request):Response
    {
        $projet = new Projet();
        $formProject = $this->createForm(ProjectFormType::class,$projet);
        $formProject->handleRequest($request);

        if($formProject->isSubmitted() && $formProject->isValid())
        {
            if($projet->getDatefin() < new \DateTime())
            {
                $this->addFlash('error', 'la date de fin est déja passé');
                return $this->redirectToRoute('app_addproject');
            }
            $entityManager->persist($projet);
            $entityManager->flush();
            return $this->redirectToRoute('app_listprojects');
        }
        return $this->render('addproject.html.twig',
        ['formProject' => $formProject->createView()
        ]);
    }
    /**
     * @Route ("/listprojects",name="app_listprojects")
     */
    public function listProjects(ProjetRepository $projetRepository):Response
    {
        $projects = $projetRepository->findAll();
        return $this->render('listProjects.html.twig',
        ['projects' => $projects]);
    }
    /**
     * @Route ("/inscription/{id}",name="app_inscription")
     */
    public function inscription(int $id,ProjetRepository $projetRepository,EtatRepository $etatRepository,
                                EntityManagerInterface $entityManager):Response
    {
        $project = $projetRepository->find($id);
        /**
         * @var Employe $participant
         */
        $participant = $this->getUser();
        $etat = $etatRepository->find(2);
        $etatClosed = $etatRepository->find(4);
         if($project->getEmployee()->count() == $project->getNbInscription())
         {
             $project->setEtat($etat);
         }
         if($project->getDatefin() < new \DateTime() )
         {
             $project->setEtat($etatClosed);
             $entityManager->persist($project);
             $entityManager->flush();
             $this->addFlash('danger', 'la date de fin est déja passé');
             return $this->redirectToRoute('app_listprojects');
         }
         $project->addEmployee($participant);
         $entityManager->persist($project);
         $entityManager->flush();

         return $this->redirectToRoute('app_listprojects');
    }
    /**
     * @Route ("/updateproject/{id}",name="app_updateproject")
     */
    public function updateProject(int $id,ProjetRepository $projetRepository,Request $request,
                                    EntityManagerInterface $entityManager):Response
    {
        $project = $projetRepository->find($id);
        $formProject = $this->createForm(ProjectFormType::class,$project);
        $formProject->handleRequest($request);

        if($formProject->isSubmitted() && $formProject->isValid())
        {
            if($project->getDatefin() < new \DateTime())
            {
                $this->addFlash('danger', 'la date de fin est déja passé');
                return $this->redirectToRoute('app_addproject');
            }
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('app_listprojects');
        }
        return $this->render('addproject.html.twig',
            ['formProject' => $formProject->createView()
            ]);
    }
    /**
     * @Route ("/deleteproject/{id}",name="app_deleteproject")
     */
    public function deleletProject(int $id,ProjetRepository $projetRepository):Response
    {
        $project = $projetRepository->find($id);
        $projetRepository->remove($project,true);
        $this->addFlash('success', 'This project is successfully deleted');
        return $this->redirectToRoute('app_listprojects');

    }
}