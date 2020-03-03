<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 */
class State extends BaseEntity
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
     * @ORM\Column(type="string", length=255)
     */
    protected $abbreviation;

    /**
     * @ORM\ManyToOne(targetEntity="Country", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="countryId", nullable=false)
     */
    protected $country;

    public function toArray(array $options = [])
    {
        $array = parent::toArray($options);

        if ($this->checkOnlyExceptInArray('country', $options)) {
            $array['country'] = $this->country->toArray(isset($options['toArrayCountry']) ? $options['toArrayCountry'] : []);
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'name',
            'abbreviation',
            'country',
        ];
    }

    public function getOnlyStore()
    {
        return [];
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
