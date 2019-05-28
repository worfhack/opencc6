<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class UserType extends AbstractType
{
    private $roleHierarchy ;
    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
   //     $this->roleHierarchy = $roleHierarchy;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

//        $container->getParameter('security.role_hierarchy.roles')
        $builder
            ->add('email')
            ->add(
                'roles', ChoiceType::class, [
                    'choices' => User::USER_ROLES,
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
           //     ->add('password')
           // ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
