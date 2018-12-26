<?php

namespace App\Form;

use App\Entity\Roles;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class TypeRegistration extends abstractType

{
    public function buildForm( FormBuilderInterface $builder, array $options ) {

        $builder
            ->add('name', TextType::class)
            ->add('secondName', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('phone', NumberType::class)
            ->add('photo',  FileType::class)
            ->add('role', EntityType::class, [
                'multiple'=> true,
                'expanded'=> true,
                'class'=> 'App\Entity\Roles',
                'choice_label' => 'name',
                'choice_value' => function (Roles $entity = null) {
                    return $entity ? $entity->getId() : '';
                },
            ])
            ->add('save', SubmitType::class, ['label' => 'Create user']);

    }
    public function configureOptions( OptionsResolver $resolver ) {
        $resolver->setDefaults( [
            'data_class' => User::class,

//            'validation_groups' => false,
        ] );
    }
}