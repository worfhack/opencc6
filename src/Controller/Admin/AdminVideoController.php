<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 22/02/19
 * Time: 11:27
 */

namespace App\Controller\Admin;
use App\Entity\Video;
use App\Repository\TrickRepository;

use App\Form\VideoType;
use App\Form\EditTrickType;

use App\Repository\VideoRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminVideoController extends AbstractController
{


    /**
     * @Route("/video/list") , name="listvideo"
     * @IsGranted("IS_AUTHENTICATED_FULLY")

     */
    public function list(VideoRepository $videoRepository)
    {
        $videos = $videoRepository->findAll();

        return $this->render('video/admin/list.html.twig', array(
            'videos' => $videos,

        ));
    }


    /**
     * @Route("/video/new" , name="newvideo")
     * @IsGranted("IS_AUTHENTICATED_FULLY")

     */
    public function new(Request $request, EntityManagerInterface $em)
        {
        $video = new Video();


        $form = $this->createForm(VideoType::class, $video);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em->persist($video);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Video bien enregistrée.');
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
              //  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }

        return $this->render('video/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/video/edit/{id}", name="editvideo" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function edit(Video $video, Request $request, EntityManagerInterface $em)
    {


        $form = $this->createForm(VideoType::class, $video);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em->persist($video);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Video bien enregistrée.');
                die("ok");
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                //  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }

        return $this->render('video/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}