<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\reg;
use App\Service\FileUploader;

class PhotoUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof reg) {
            return;
        }

        $file = $entity->getPhoto();

        // загружать только новые файлы
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setPhoto($fileName);
        }
    }
}