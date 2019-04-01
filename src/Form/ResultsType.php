<?php

namespace App\Form;

use App\Entity\Results;
use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ResultsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('takenAnswer', CheckboxType::class, [
//                'label'    => 'Show this entry publicly?',
//                'required' => false,
//            ])
            ->add('takenAnswer')
//            ->add('takenAnswer', EntityType::class, [
//                'multiple'=> true,
//                'expanded'=> true,
//                'class'=> 'App\Entity\Answer',
//                'choice_label' => 'answer',
//                'choice_value' => function (Answer $entity = null) {
////                    return $entity ? $entity->getId() : '';
//                    return $entity ? $entity->getId(): '';
//                },
//            ])
//            ->add('question')
//            ->add('resultAnswer')
        ;
//        ->add('emergency_type', ChoiceType::class, array(
//        'label' => 'Emergency Contact Relationship',
//        'choices' => array(
//            'Spouse' => 'Spouse',
//            'Family Friends' => 'Family Friends',
//            'Other' => 'Other',
//        ),
//        'expanded' => true,
//        'required'=>true,
//    ))
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Results::class,
        ]);
    }
}
