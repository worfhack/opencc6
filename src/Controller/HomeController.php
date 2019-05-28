<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 08/02/19
 * Time: 21:47
 */

namespace App\Controller;

use App\Repository\TagRepository;
use App\Repository\TrickRepository;
use App\Service\Configuration;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{


    /**
     * @Route("/", name="hommepage")
     */

    public function index(TrickRepository $trickRepository, TagRepository $tagRepository, Configuration $configuration) // autloading
    {

        $nbrTrickHomePage = $configuration->get('NBPOSTHOME', 5);
        //$tricks = $trickRepository->findBy(array(),   array('position'=>'asc'), $nbrTrickHomePage );
        $tricks = $trickRepository->getTricks(0, $nbrTrickHomePage);
        $nbrTricks = $tricks->count();
        $tags = $tagRepository->findAll();
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'nbrTricks'=>$nbrTricks,
            'homeBG'=>$configuration->get('HOMEIMAGEBACKGROUND'),
            'sliderTitle'=>$configuration->get('HOMETITLE'),
            'sliderSubTitle'=>$configuration->get('HOMESUBTITLE'),
            'page'=>ceil($nbrTricks / $nbrTrickHomePage),
            'tags' => $tags
        ]);
    }
}