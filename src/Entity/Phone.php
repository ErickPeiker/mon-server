<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Phone extends BaseEntity
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $number;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="phones", cascade={"persist"})
     * @ORM\JoinColumn(name="personId", nullable=false)
     */
    protected $person;

    protected function getFillable()
    {
        return [
            'id',
            'number',
            'person',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'number',
            'person',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
