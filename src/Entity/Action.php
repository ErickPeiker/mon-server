<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use App\Enumerator\ActionType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Action extends BaseEntity
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
     * @ORM\Column(type="ActionType")
     */
    protected $type;

    /**
     * @ORM\Column(type="json")
     */
    protected $parameters = [];

    /**
     * @ORM\ManyToOne(targetEntity="Criteria", inversedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(name="criteriaId", nullable=false)
     */
    protected $criteria;

    protected function getFillable()
    {
        return [
            'id',
            'type',
            'parameters',
            'criteria',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'type',
            'parameters',
            'criteria',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getCriteria(): ?Criteria
    {
        return $this->criteria;
    }

    public function setCriteria(?Criteria $criteria): self
    {
        $this->criteria = $criteria;

        return $this;
    }
}
