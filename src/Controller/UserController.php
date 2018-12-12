<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\TypeRegistration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Routing\Annotation\Route;
class UserController extends AbstractController
{
    /**
     * @Route("/user/registration")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationForm(Request $request)
    {
        $registration = new User();
        $form = $this->createForm(TypeRegistration::class, $registration);

        $form->handleRequest($request);
        dump($form->getData());

        return $this->render('user/registration.html.twig', array(
            'form' => $form->createView(),
//            'form' => $form->getData()
//            $name = $form->get('name')->getData()
        ));
    }
}