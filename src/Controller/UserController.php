<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\TypeRegistration;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/user/registration", name="registration")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationForm(Request $request, FileUploader $fileUploader)
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
            'form2' => $form['name']->getData()
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/userPhoto/photo/{id}", name="user_show")
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $photo = $user->getPhoto();

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->render('userPhoto/photo.html.twig', array(
            'photo' => $photo
        ));
    }
    /**
     * @Route("/userList/list", name="user_list")
     */
    public function showUserList()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('userList/list.html.twig', [
            'users'=>$users
        ]);
    }



    /**
     * @Route("/delete/{id}", name="deleteUser")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user_list', [
//            'id'=>$id,
        ]);
    }
    /**
     * @Route("/user/edit/{id}")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $new_name = 'New User name!';

        $user->setName($new_name);
        $em->flush();

        return $this->redirectToRoute('user_list');
    }
    /**
     * @Route("/overview/overview/{id}", name="user_overview")
     */
    public function overviewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
//        $em = $this->getDoctrine()->getManager();
//        $users = $em->getRepository(User::class)->find($id)
//        $user = $users->findBy(['id' => $id]);

//        if (!$users) {
//            throw $this->createNotFoundException(
//                'No user found for id '.$id
//            );
//        }

//        return $this->render('/overview/overview/{id}', [
        return $this->render('/overview/overview.html.twig', [
            'id'=>$id,
            'user'=>$user
        ]);
    }
}