<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
//    private $id;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     * @Assert\Length(max=22)
     */
    public $name;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     * @Assert\Length(max=22)
     */
    public $secondName;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    public $email;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=8)
     * @Assert\Length(max=22)
     */
    public $password;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     * @Assert\Length(max=22)
     */
    public $phone;
    /**
     * @Assert\NotBlank
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 4000,
     *     minHeight = 200,
     *     maxHeight = 4000
     * )
     */
    public $photo;

    public $role;

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
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }
    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
    public function getPhoto(): ?string
    {
        return $this->photo;
    }
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
}
