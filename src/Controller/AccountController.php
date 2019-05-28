<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 12/04/19
 * Time: 16:09
 */

namespace App\Controller;

use App\Form\EditTrickType;
use App\Form\ProfilType;
use App\Service\FileUploader;
use App\Service\SnowPhpthumb;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/account", name="accountpage" )
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(Request $request, EntityManagerInterface $em, FileUploader $fileUploader, SnowPhpthumb $snowPhpthumb)
    {
        $user = $this->getUser();
        $currentAvatar = $user->getAvatar();


        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);


        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('avatar')->getData();
            if ($file) {


                $fileName = $fileUploader->upload($file);
                $snowPhpthumb->resize($fileName);
                $user->setAvatar($fileName);
            }else
            {
                $user->setAvatar($currentAvatar);
            }
            $em->persist($user);
            $em->flush();
            //            $image->setPath($fileName);
        }
        return $this->render('security/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
        //   $user =
    }
}