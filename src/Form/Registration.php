<?php

namespace App\Form;


class Registration
{
    public function registrationForm(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $user = new User();
        $form = $this->createFormBuilder($user)
//            ->setAction($this->generateUrl(__DIR__.'/../Entity/formData.php'))
            ->add('name', TextType::class)
            ->add('secondName', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('phone', NumberType::class)
            ->add('photo', TextType::class)
            ->add('roles', ChoiceType::class, array(
                'label' => 'Role ',
                'choices'  => array(
                    'Super admin' => 3,
                    'Admin' => 2,
                    'Student' => 1,
                    'Abiturient' => 0,
                )))
            ->add('save', SubmitType::class, array('label' => 'Create user'))
            ->getForm();
        $form->handleRequest($request);
        dump($form->getData());
        return $this->render('user/registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}