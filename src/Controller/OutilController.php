<?php

namespace App\Controller;


use App\Entity\Outil;
use App\Form\OutilFormType;
use App\Repository\OutilRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OutilController extends AbstractController
{
    /**
     * @Route ("/addoutil" , name="app_addoutil")
     */
    public function addOutil(Request $request,EntityManagerInterface $entityManager) : Response
    {
        $outil = new Outil();
        $outilForm = $this->createForm(OutilFormType::class,$outil);
        $outilForm->handleRequest($request);
        if($outilForm->isSubmitted() && $outilForm->isValid())
        {
            $this->addFlash('success', 'This tool is successfully added');
            $entityManager->persist($outil);
            $entityManager->flush();
            return  $this->redirectToRoute('app_listoutils');
        }
        return $this->render('addoutil.html.twig',
        ['formoutil' => $outilForm->createView()]);
    }
    /**
     * @Route ("/updateoutil/{id}" , name="app_updateoutil")
     */
    public function updateOutil(int $id,Request $request,EntityManagerInterface $entityManager,OutilRepository $outilRepository) : Response
    {
        $outil = $outilRepository->find($id);
        $outilForm = $this->createForm(OutilFormType::class,$outil);
        $outilForm->handleRequest($request);
        if($outilForm->isSubmitted() && $outilForm->isValid())
        {
            $this->addFlash('success', 'This tool is successfully updated');
            $entityManager->persist($outil);
            $entityManager->flush();
            return  $this->redirectToRoute('app_listoutils');
        }
        return $this->render('updateOutil.html.twig',
            ['formoutil' => $outilForm->createView()]);
    }
    /**
     * @Route ("/listoutils" , name="app_listoutils")
     */
    public function listOutils(OutilRepository $outilRepository) : Response
    {
        $outils = $outilRepository->findAll();
        return $this->render('listOutils.html.twig',
            ['outils' => $outils]);
    }
    /**
     * @Route ("/iframe" , name="app_iframe")
     */
    public function iframe() : Response
    {
        return $this->render('iframe.html.twig');
    }
    /**
     * @Route ("/deleteoutil/{id}" , name="app_deleteoutil")
     */
    public function deleteOutil(int $id,OutilRepository $outilRepository) : Response
    {

        $outil = $outilRepository->find($id);
        $outilRepository->remove($outil,true);
        $this->addFlash('success', 'This tool is successfully deleted');
        return $this->redirectToRoute('app_listoutils');
    }
    /**
     * @Route ("/formoutil/{id}" , name="app_formoutil")
     */
    public function formOutil(int $id,OutilRepository $outilRepository) : Response
    {

        $outil = $outilRepository->find($id);
        $formHTML = $outilRepository->JsonToFormHtml($outil->getParametres());

        return $this->render('formHTML.html.twig',
            ['formHTML' => $formHTML
            ]);
    }
    /**
     * @Route ("/finbyname",name ="app_finbyname")
     */
    public function finByName(Request $request,OutilRepository $outilRepository) :Response
    {
        $name = $request->request->get('name');

        $outil = $outilRepository->findByName($name);

        return $this->render('listOutils.html.twig',['outil' => $outil]);
    }
}