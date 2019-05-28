<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 22/02/19
 * Time: 11:27
 */

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\EditTrickType;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use App\Service\SnowPhpthumb;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminImageController extends AbstractController
{


    /**
     * @Route("/image/list" , name="listimage")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function list(ImageRepository $ImageRepository)
    {
        $images = $ImageRepository->findAll();

        return $this->render('image/admin/list.html.twig', array(
            'images' => $images,

        ));
    }

    /**
     * @Route("/image/new", name="newimage")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request, EntityManagerInterface $em, FileUploader $fileUploader,

                        SnowPhpthumb $snowPhpthumb)
    {
        $image = new Image();


        $form = $this->createForm(ImageType::class, $image);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            $file = $form->get('path')->getData();//todo a valider car pas du tout confrome à la documentation/
            $fileName = $fileUploader->upload($file);
            $image->setPath($fileName);

            $snowPhpthumb->resize($fileName);
            if ($form->isValid()) {
                $em->persist($image);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Image bien enregistrée.');
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                //  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            }
        }

        return $this->render('image/admin/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/image/edit/{id}", name="editimage" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function edit(Image $image, Request $request, EntityManagerInterface $em, FileUploader $fileUploader, SnowPhpthumb $snowPhpthumb)
    {

        $path = $image->getPath();
        //  $image->setPath(new File("./uploads/trick/" . $path));
        $form = $this->createForm(ImageType::class, $image);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            // $file = $image->getPath();

            $file = $form->get('path')->getData();//todo a valider car pas du tout confrome à la documentation
            $fileName = $fileUploader->upload($file);

            $snowPhpthumb->resize($fileName);

            $image->setPath($fileName);

            if ($form->isValid()) {
                $em->persist($image);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Image bien enregistrée.');

            }
        }

        return $this->render('image/admin/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/image/delete/{id}", name="deleteImage", )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Image $image, Request $request, UrlGeneratorInterface $urlGenerator
        , TrickRepository $trickRepository, EntityManagerInterface $em)
    {

        $id_trick = $image->getId();
        if (!$id_trick) {
            throw new NonUniqueResultException("Cette image  n'éxiste pas");
        }

        $em->remove($image);
        $em->flush();
        $request->getSession()->getFlashBag()->add('deleteTrick', 'L\'image  à bien été supprimé');
        return new RedirectResponse($urlGenerator->generate('listimage'),
            RedirectResponse::HTTP_FOUND);
    }
}