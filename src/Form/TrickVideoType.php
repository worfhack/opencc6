<?php

namespace App\Form;

use App\Entity\Video;
use App\Entity\TrickVideo;
use App\Repository\VideoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
class TrickVideoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {

        $builder
            ->add('videoList', EntityType::class, [
                'class' => Video::class,
                  'choice_label' => 'url',
//                'query_builder' => function(VideoRepository $repo) {
//
//                        $r =  $repo->findAllQueryBuilder();
//                     return $r;
//                }

            ])
         //   ->add('position')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickVideo::class
        ]);
    }

}
