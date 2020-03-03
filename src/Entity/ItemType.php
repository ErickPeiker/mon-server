<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use App\Enumerator\ValueType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class ItemType extends BaseEntity
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
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\Column(type="ValueType")
     */
    protected $valueType;

    /**
     * @ORM\ManyToOne(targetEntity="EquipmentType", cascade={"persist"})
     * @ORM\JoinColumn(name="equipmentTypeId", nullable=false)
     */
    protected $equipmentType;

    public function toArray(array $options = [])
    {
        $array = parent::toArray($options);

        if ($this->checkOnlyExceptInArray('equipmentType', $options)) {
            $array['equipmentType'] = $this->equipmentType->toArray(isset($options['toArrayEquipmentType']) ? $options['toArrayEquipmentType'] : []);
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'name',
            'slug',
            'valueType',
            'equipmentType',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'name',
            'slug',
            'valueType',
            'equipmentType',
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setValueType(string $valueType): self
    {
        $this->valueType = $valueType;

        return $this;
    }

    public function getEquipmentType(): ?EquipmentType
    {
        return $this->equipmentType;
    }

    public function setEquipmentType(?EquipmentType $equipmentType): self
    {
        $this->equipmentType = $equipmentType;

        return $this;
    }
}
