<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 22/02/19
 * Time: 11:27
 */

namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminTrickController extends AbstractController
{

    /**
     * @Route("/trick/list") , name="listtrick"
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function list(TrickRepository $trickRepository)
    {
        $tricks = $trickRepository->findBy(array(), array('position' => 'asc'));

        return $this->render('trick/admin/list.html.twig', array(
            'tricks' => $tricks,

        ));
    }


    /**
     * @Route("/trick/new" , name="addtrick")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request, EntityManagerInterface $em, TrickRepository $trickRepository)
    {
        $trick = new Trick();


        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
//        dump($_POST);
//        dump($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $position = 0;
            if ($trick->getTrickImages()->count()) {
                foreach ($trick->getTrickImages() as $v) {
                    $v->setPosition($position++);

                }
            }
            if ($trick->getTrickVideos()->count()) {
                foreach ($trick->getTrickVideos() as $v) {
                    $v->setPosition($position++);

                }
            }
            $em->persist($trick);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistrée.');
            return $this->redirectToRoute('edittrick', ['id' => $trick->getId()]);


        }
        return $this->render('trick/form.html.twig', array(
            'form' => $form->createView(),
            'trick' => $trick,
        ));
    }

    /**
     * @Route("/trick/setPosition/{id}", name="setPosition" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function setPosition(Trick $trick, Request $request, EntityManagerInterface $em, TrickRepository $trickRepository)
    {
        $new_position = $request->get('position');

        $old_position = $trick->getPosition();

        $trickRepository->cleanPosition($old_position, $new_position);
        $trick->setPosition($new_position);
        $em->persist($trick);
        $em->flush();
        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');

        //  var_dump($request->get('position'));
        return $response;

    }

    /**
     * @Route("/trick/edit/{id}", name="edittrick" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function edit(Trick $trick, Request $request, EntityManagerInterface $em)
    {

//        dump($trick->getImage()->indexOf(1));
//        die();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {




            $position = 0;
            if ($trick->getTrickImages()->count()) {
                foreach ($trick->getTrickImages() as $v) {

                    $v->setPosition($position++);

                }
            }
            if ($trick->getTrickVideos()->count()) {
                foreach ($trick->getTrickVideos() as $v) {
                    $v->setPosition($position++);

                }
            }
            $em->persist($trick);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistrée.');

        }
        return $this->render('trick/form.html.twig', array(
            'trick' => $trick,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/trick/delete/{id}", name="deletetrick", )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Trick $trick, Request $request, UrlGeneratorInterface $urlGenerator
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