<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Answer;
use App\Form\AnswerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
//            ->add('test', HiddenType::class, [
//                'data' => 6,
//            ]);
        ;

        $builder->add('answer', AnswerType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'cascade_validation' => true,
        ]);
    }
}
