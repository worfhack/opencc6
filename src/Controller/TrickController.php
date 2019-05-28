<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 08/02/19
 * Time: 21:47
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\TrickImage;
use App\Form\CommentsType;
use App\Repository\TrickRepository;
use App\Repository\TrickImageRepository;
use App\Repository\TrickVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TagRepository;
use App\Service\Configuration;

class TrickController extends AbstractController
{

    /**
     * @var TrickRepository
     */
    private $repository;
    private $repositoryImage;
    private $repositoryVideo;

    public function __construct(TrickRepository $repository,
                                TrickImageRepository $repositoryImage,
                                TrickVideoRepository $repositoryVideo)
    {
        $this->repository = $repository;
        $this->repositoryImage = $repositoryImage;
        $this->repositoryVideo = $repositoryVideo;

    }

    /**
     * @Route("/trick/page/{page}", name="listtrick")
     */

    public function list($page, TrickRepository $trickRepository, TagRepository $tagRepository, Configuration $configuration) // autloading
    {

        $nbrTrickHomePage = $configuration->get('NBPOSTHOME', 5);

        $first = $page * $nbrTrickHomePage;
        //$tricks = $trickRepository->findBy(array(),   array('position'=>'asc'), $nbrTrickHomePage );
        $tricks = $trickRepository->getTricks($first, $nbrTrickHomePage);
        $nbrTricks = $tricks->count();
        $tags = $tagRepository->findAll();
        return $this->render('trick/ajax.html.twig', [
            'tricks' => $tricks,
            'nbrTricks'=>$nbrTricks,
            'page'=>ceil($nbrTricks / $nbrTrickHomePage),
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trickSlug" )
     */

    public function index(Trick $trick, Request $request, EntityManagerInterface $em)
    {

        $comments = new Comment();
        $formComments = $this->createForm(CommentsType::class, $comments);
        $formComments->handleRequest($request);

        if ($formComments->isSubmitted() && $formComments->isValid()) {
            $user = $this->getUser();
            $comments->setTrick($trick);
            $comments->setUser($user);
            $em->persist($comments);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistrée.');
            return $this->redirectToRoute('trickSlug', ['slug' => $trick->getSlug()]);
        }
        return $this->render('trick/index.html.twig', [
            'trick' => $trick,
            'formComments' => $formComments->createView(),
        ]);
    }
}