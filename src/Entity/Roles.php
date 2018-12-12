<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Roles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $user;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function getUser(): ?string
    {
        return $this->user;
    }
    public function setUser(string $user): self
    {
        $this->user = $user;
        return $this;
    }
}