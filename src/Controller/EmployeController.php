<?php

namespace App\Controller;


use App\Entity\Employe;
use App\Form\RegistrationFormType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EmployeController extends AbstractController
{
    /**
     * @Route ("/modifuser/{id}",name="app_updateuser")
     */
    public function updateUser(int $id,EmployeRepository $employeRepository,EntityManagerInterface $entityManager,
                                    Request $request,UserPasswordHasherInterface $userPasswordHasher,Security $security) :Response
    {

            $infoEmploye = $employeRepository->find($id);
            $formEmploye = $this->createForm(RegistrationFormType::class,$infoEmploye);
            $formEmploye->handleRequest($request);

            if($formEmploye->isSubmitted() && $formEmploye->isValid())
            {
                //la comme vous voyez ,on fait le hachage de plainMotPasse la confirmation de motPasse
                //remarque :le changement de nom ne change rien dans la BDD ,il reste toujours motPasse dans la BDD
                //et on va bien avoir le motPasse haché dans notre BDD
                $infoEmploye->setMotPasse( $userPasswordHasher->hashPassword($infoEmploye,
                    $formEmploye->get('plainPassword')->getData()));

                $entityManager->persist($infoEmploye);
                $entityManager->flush();
                return  $this->redirectToRoute('app_m');
            }
        return $this->render('modifUser.html.twig',
        ['formEmploye' => $formEmploye->createView(),
            'employe' => $infoEmploye ]);

    }
    /**
     * @Route ("/profil",name ="app_profil")
     */
    public function afficherProfil() : Response
    {
        return $this->render('profil.html.twig');
    }
    /**
     * @Route ("/listusers",name ="app_listusers")
     */
    public function listUsers(EmployeRepository $employeRepository) : Response
    {
        $list = $employeRepository->findAll();
        return $this->render('listUsers.html.twig',[
            'users' => $list
        ]);
    }
    /**
     * @Route ("/deleteuser/{id}",name ="app_deleteuser")
     */
    public function deletUser(int $id,EmployeRepository $employeRepository) :Response
    {
        $user = $employeRepository->find($id);
        $employeRepository->remove($user,true);
        return $this->redirectToRoute('app_listusers');
    }

}