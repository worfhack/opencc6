<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 22/02/19
 * Time: 11:27
 */

namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Form\TagType;
use App\Repository\TagRepository;
use App\Repository\TrickRepository;
use App\Entity\Tag;

use App\Form\TrickType;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AdminTagController extends AbstractController
{


    /**
     * @Route("/tag/list") , name="listtag"
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function list(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render('tag/list.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * @Route("/tag/new") , name="addTag"
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request  , EntityManagerInterface $em)
    {
        $tag = new Tag();


        $form = $this->createForm(TagType::class, $tag);


        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em->persist($tag);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Tag bien enregistrée.');
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                //  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }
        return $this->render('tag/form.html.twig', array(
            'form' => $form->createView(),
            'trick' => $tag,
        ));
    }

    /**
     * @Route("/tag/edit/{id}", name="edittag" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function edit(Tag $tag, Request $request, EntityManagerInterface $em)
    {

//        dump($trick->getImage()->indexOf(1));
//        die();
        $form = $this->createForm(TagType::class, $tag);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On enregistre notre objet $advert dans la base de données, par exemple
                $em->persist($tag);
                $em->flush();


                //                 $trick->addImage($trick->getImages());
                $request->getSession()->getFlashBag()->add('notice', 'Image bien enregistrée.');
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                //  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            } else {
            }
        }
        return $this->render('tag/form.html.twig', array(
            'trick' => $tag,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/delete/{slug}", name="deletetrick", )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Trick $trick, Request $request,         UrlGeneratorInterface $urlGenerator
                           , TrickRepository $trickRepository, EntityManagerInterface $em)
    {

        $id_trick = $trick->getId();
        if (!$id_trick) {
            throw new NonUniqueResultException("Ce Trick n'éxiste pas");
        }

        $em->remove($trick);
        $em->flush();
        $request->getSession()->getFlashBag()->add('deleteTrick', 'Le trick à bien été supprimé');
        return new RedirectResponse($urlGenerator->generate('hommepage'),
            RedirectResponse::HTTP_FOUND);
    }

}