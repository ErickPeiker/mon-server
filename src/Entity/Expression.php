<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use App\Enumerator\FunctionType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpressionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Expression extends BaseEntity
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
     * @ORM\Column(type="FunctionType", name="`function`")
     */
    protected $function;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $parameter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $item;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $logicalComparator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $value;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sequence;

    /**
     * @ORM\ManyToOne(targetEntity="ItemType", cascade={"persist"})
     * @ORM\JoinColumn(name="itemTypeId", nullable=false)
     */
    protected $itemType;

    /**
     * @ORM\ManyToOne(targetEntity="Criteria", inversedBy="expressions", cascade={"persist"})
     * @ORM\JoinColumn(name="criteriaId", nullable=false)
     */
    protected $criteria;

    protected function getFillable()
    {
        return [
            'id',
            'function',
            'parameter',
            'item',
            'logicalComparator',
            'value',
            'sequence',
            'itemType',
            'criteria',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'function',
            'parameter',
            'item',
            'logicalComparator',
            'value',
            'sequence',
            'itemType',
            'criteria',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(?string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(?string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getLogicalComparator(): ?string
    {
        return $this->logicalComparator;
    }

    public function setLogicalComparator(string $logicalComparator): self
    {
        $this->logicalComparator = $logicalComparator;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getItemType(): ?ItemType
    {
        return $this->itemType;
    }

    public function setItemType(?ItemType $itemType): self
    {
        $this->itemType = $itemType;

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
