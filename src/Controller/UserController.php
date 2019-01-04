<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\TypeRegistration;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    public function registrationForm(Request $request , FileUploader $fileUploader)
    {
        $user = new User();
        $form = $this->createForm(TypeRegistration::class, $user);
        $form->handleRequest($request);





        if ($form->isSubmitted() && $form->isValid()) {
//            dump($form['role']->getData());exit;
            $em = $this->getDoctrine()->getManager();


            $file = $user->getPhoto();
            $fileName = $fileUploader->upload($file);

            $user->setPhoto($fileName);
//            $file = $user->getPhoto();
//
//            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('photos_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                echo 'EXCEPTION';
            }
            $user->setPhoto($fileName);
            $em->persist($user);
            $em->flush();
            dump($form->getData());
//            return $this->redirect($this->generateUrl('/user/list'));
        };







        return $this->render('user/registration.html.twig', array(
            'form' => $form->createView(),
//            'form' => $form->getData()
        ));
    }

//    public function new(Request $request, FileUploader $fileUploader){
//        $user = new User();
//        $form = $this->createForm(TypeRegistration::class, $user);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $file = $user->getPhoto();
//            $fileName = $fileUploader->upload($file);
//
//            $user->setPhoto($fileName);
//        }
//    }



    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}