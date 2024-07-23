<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private string $email;

    #[Assert\NotBlank()]
    private string $name;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 5)]
    private string $message;

    private string $service;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of service
     */ 
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set the value of service
     *
     * @return  self
     */ 
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }
}
