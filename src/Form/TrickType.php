<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Tag;
use App\Entity\TrickImage;
use App\Entity\TrickVideo;
use App\Entity\Video;

use App\Entity\Trick;
use App\Form\ImageType;
use http\Url;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\TrickImageType;
use App\Form\TrickVideoType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('description')
            // ->add('images')
            ->add('name')
            ->add('tag', EntityType::class, [
                // looks for choices from this entity
                'class' => Tag::class,
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',

            ])            //->add('tag')
            ->add('trickImages', CollectionType::class, [
                'entry_type' => TrickImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                //'delete_empty' => true,
                //'prototype' => true,
                'by_reference' => false, // <--- you missed this
            ])
            ->add('trickVideos', CollectionType::class, [
                'entry_type' => TrickVideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false, // <--- you missed this
            ])
            ->add('Submit',SubmitType::class, array('label' => 'Send Answer'))

            // ->add('save', SubmitType::class);
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
           // "allow_extra_fields"=>true,
        ]);
    }
}
