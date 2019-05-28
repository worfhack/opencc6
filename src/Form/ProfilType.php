<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('')
            // ->add('roles')
//           ->add('password', PasswordType::class, array(
//               'translation_domain' => false,
//           ))
            ->add("firstname")
            ->add('lastname')
            ->add('description')
            ->add('avatar', FileType::class, array(
                'data_class' => null,
                'required'=>false,

            ))
            ->add('save', SubmitType::class);// ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
