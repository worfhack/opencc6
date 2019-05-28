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
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TagController extends AbstractController
{
    /**
     * @Route("/tag/{slug}", name="tag")
     */

    public function index(TrickRepository $trickRepository, TagRepository $tagRepository) // autloading
    {

        $tricks = $trickRepository->findAll();
        $tags = $tagRepository->findAll();
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'tags' => $tags
        ]);
    }
}