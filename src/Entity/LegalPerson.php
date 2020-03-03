<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LegalPersonRepository")
 */
class LegalPerson extends Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cnpj;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $ie;

    protected function getFillable()
    {
        return [
            'id',
            'name',
            'cnpj',
            'ie',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'name',
            'cnpj',
            'ie',
        ];
    }

    public function getId(): ?string
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

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): self
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getIe(): ?string
    {
        return $this->ie;
    }

    public function setIe(?string $ie): self
    {
        $this->ie = $ie;

        return $this;
    }
}
