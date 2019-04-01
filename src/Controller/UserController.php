<?php
namespace App\Controller;
use App\Entity\reg;
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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends controller
{
    /**
     * @Route("/user/registration", name="registration", methods="GET|POST", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function new(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = new reg();

        $form = $this->createForm(TypeRegistration::class, $user);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('photo')->getData();
                if ($file) {
                    $checkMime = $this->checkImage($file->getMimeType());
                    if (!$checkMime) {
                        $form->get('photo')->addError(new FormError('Uploaded file is not a valid image'));
                        return $this->render('user/registration.html.twig', [
                            'user' => $user,
                            'form' => $form->createView(),
                        ]);
                    }

                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists('../public/uploads/photos')) {
                        $fileSystem->mkdir('../public/uploads/photos', 0777);
                    }

                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                    $file->move(
                    $this->getParameter('photos_directory'),
                    $fileName
                );

                    $user->setPhoto($fileName);
                }


                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('user_list');
            }


            return $this->render('user/registration.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

//    public function registrationForm(Request $request, FileUploader $fileUploader)
//    {
//        $user = new User();
//        $form = $this->createForm(TypeRegistration::class, $user);
//        $form->handleRequest($request);
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//
//
//            $file = $user->getPhoto();
//            $fileName = $fileUploader->upload($file);
//
//            $user->setPhoto($fileName);
//
//            try {
//                $file->move(
//                    $this->getParameter('photos_directory'),
//                    $fileName
//                );
//            } catch (FileException $e) {
//                echo 'EXCEPTION';
//            }
//            $user->setPhoto($fileName);
//            $em->persist($user);
//            $em->flush();
//            dump($form->getData());
//        };
//
//
//        return $this->render('user/registration.html.twig', array(
//            'form' => $form->createView(),
//            'user' => $user
//        ));
//    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }


    /**
     * @Route("/user/edit/{id}", name="edit_user", methods="GET|POST")
     * @param Request $request
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("App:User")->find($id);
//        dump($user);


        $form = $this->createForm(TypeRegistration::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
//        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $deletePhoto =$request->request->get('photoDelete');
            $oldFile = $user->getPhoto();

            if ($file) {
                $checkMime = $this->checkImage($file->getMimeType());
                if (!$checkMime) {
                    $form->get('photo')->addError(new FormError('Uploaded file is not a valid image'));
                    return $this->render('edit/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView(),
//                        'isedit'=>true,
                    ]);
                }

                $fileSystem = new Filesystem();

                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                if ($oldFile && $fileSystem->exists('../public/uploads/photos/' . $oldFile)) {
                    unlink($this->get('kernel')->getRootDir() . '/../public/uploads/photos/'.$oldFile);
                }

                $file->move(
                    $this->get('kernel')->getRootDir() . '/../public/uploads/photos/',
                    $fileName
                );

                $user->setPhoto($fileName);

            } elseif ($deletePhoto){
                if ($oldFile) {
                    unlink($this->getParameter('photos_directory').$oldFile);
                }

                $user->setPhoto(null);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success','User was successfully updated');

            return $this->redirectToRoute('user_list', ['id' => $user->getId()]);
        }
//        if ($form->isSubmitted() && !$form->isValid()) {
//            $this->addFlash('error','Error while saving Arbitration Attorney');
//        }

        return $this->render('edit/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


//    public function editAction(Request $request, FileUploader $fileUploader, User $user): Response
//    {
//        $form = $this->createForm(TypeRegistration::class, $user);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
////            $this->getDoctrine()->getManager()->flush();
//            $em = $this->getDoctrine()->getManager();
//
//
////            $file = $form->getPhoto();
//            $deletePhoto =$request->request->get('photoDelete');
//            $file = $form->get('photo')->getData();
//            $oldFile = $user->getPhoto();
//
//            if ($file) {
//                    $form->get('photo')->addError(new FormError('Uploaded file is not a valid image'));
//                    return $this->render('arb_attorney/edit.html.twig', [
//                        'user' => $user,
//                        'form' => $form->createView(),
//                        'isedit'=>true,
//                    ]);
//
//                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
//
//                $file->move(
//                    $this->get('kernel')->getRootDir() . '/../public/uploads/signature/',
//                    $fileName
//                );
//
//                $user->setPhoto($fileName);
//
//            } elseif ($deletePhoto){
//                if ($oldFile) {
//                    unlink($this->get('kernel')->getRootDir() . '/../public/uploads/signature/'.$oldFile);
//                }
//
//                $user->setPhoto(null);
//            }
//
//
//
//            $fileName = $fileUploader->upload($file);
//
//            $user->setPhoto($fileName);
//
//            try {
//                $file->move(
//                    $this->getParameter('photos_directory'),
//                    $fileName
//                );
//            } catch (FileException $e) {
//                echo 'Photos directory not found';
//            }
//            $user->setPhoto($fileName);
//
//
//            $em->flush();
//
//            return $this->redirectToRoute('user_list'
//                ,['id' => $user->getId()]
//            );
//        }
//
//        return $this->render('edit/edit.html.twig', [
//            'form' => $form->createView(),
//            'user' => $user
//        ]);
//    }



//    /**
//     * @Route("/user/edit/{id}")
//     */
//    public function updateAction($id)
//{
//
//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository(User::class)->find($id);
//
//        if (!$user) {
//            throw $this->createNotFoundException(
//                'No user found for id '.$id
//            );
//        }
//        $new_name = 'New User name!';
//
//        $user->setName($new_name);
//        $em->flush();
//
//        return $this->redirectToRoute('user_list');
//    }

    /**
     * @Route("/userList/list", name="user_list")
     */

    public function showUserList()
    {
        $repository = $this->getDoctrine()->getRepository(reg::class);
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
        $user = $em->getRepository(reg::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/overview/overview/{id}", name="user_overview")
     */
    public function overviewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(reg::class)->find($id);
        $a = dump($user);
        return $this->render('/overview/overview.html.twig', [
            'id'=>$id,
            'user'=>$user,
            'a'=>$a
        ]);
    }
    /**
     * @param $type
     * @return bool
     */
    private function checkImage($type)
    {
        $array = ['image/gif', 'image/png', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/img'];
        if (in_array($type, $array)) {
            return true;
        } else {
            return false;
        }
    }
}