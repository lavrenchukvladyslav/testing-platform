<?php
namespace App\Form;
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
class RegistrationType extends abstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ) {
        $builder

            ->add('name', TextType::class)
            ->add('secondName', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('phone', NumberType::class)
            ->add('photo', FileType::class)
            ->add('role', CollectionType::class, array(

                'label' => 'role',
                'entry_type' => ChoiceType::class,
                'entry_options'  => array(
                    'choices'  => array(
                        'Super admin' => 3,
                        'Admin' => 2,
                        'Student' => 1,
                        'Abiturient' => 0,
                    ),
                ),
                'allow_add' => true,
                'prototype' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Create user'));
    }
    public function configureOptions( OptionsResolver $resolver ) {
        $resolver->setDefaults( [
            'data_class' => User::class,
//            'data_class1' => User::class,
//            'data_class2' => User::class,
//            'validation_groups' => false,
        ] );
    }
}
