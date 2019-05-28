<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\TrickImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {

        $builder
            ->add('imageList', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'path',

            ])
            ->add('thumbnail', CheckboxType::class,
                [
                    'label' => 'Show this entry publicly?',
                    'required' => false,
                ]
            );
            //->add('position', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickImage::class
        ]);
    }

}
