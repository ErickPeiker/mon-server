<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "LEGAL_PERSON" = "LegalPerson",
 *     "PHYSICAL_PERSON" = "PhysicalPerson"
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
abstract class Person extends BaseEntity
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
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person", cascade={"persist"}, orphanRemoval=true)
     */
    protected $phones;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="person", cascade={"persist"}, orphanRemoval=true)
     */
    protected $addresses;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    public function toArray(array $options = [])
    {
        $array = parent::toArray($options);

        if ($this->checkOnlyExceptInArray('addresses', $options)) {
            $array['addresses'] = [];
            foreach ($this->addresses as $addresses) {
                $array['addresses'][] = $addresses->toArray(isset($options['toArrayAddresses']) ? $options['toArrayAddresses'] : []);
            }
        }

        if ($this->checkOnlyExceptInArray('phones', $options)) {
            $array['phones'] = [];
            foreach ($this->phones as $phones) {
                $array['phones'][] = $phones->toArray(isset($options['toArrayPhones']) ? $options['toArrayPhones'] : []);
            }
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'phones',
            'addresses',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'phones',
            'addresses',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setPerson($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->contains($phone)) {
            $this->phones->removeElement($phone);
            // set the owning side to null (unless already changed)
            if ($phone->getPerson() === $this) {
                $phone->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setPerson($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getPerson() === $this) {
                $address->setPerson(null);
            }
        }

        return $this;
    }
}
