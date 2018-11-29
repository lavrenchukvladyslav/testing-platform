<?php

namespace App\Entity;

class User
{
    protected $name;
    protected $secondName;
    protected $email;
    protected $password;
    protected $phone;
    protected $photo;
    protected $role;


    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getSecondName()
    {
        return $this->secondName;
    }
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
}
