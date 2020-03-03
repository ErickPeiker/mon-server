<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use App\Enumerator\WidgetType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WidgetRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Widget extends BaseEntity
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
     * @ORM\Column(type="WidgetType")
     */
    protected $type;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $parameters = [];

    /**
     * @ORM\Column(type="json")
     */
    protected $gridPosition = [];

    /**
     * @ORM\ManyToOne(targetEntity="Dashboard", inversedBy="widgets", cascade={"persist"})
     * @ORM\JoinColumn(name="dashboardId", nullable=false)
     */
    protected $dashboard;

    protected function getFillable()
    {
        return [
            'id',
            'name',
            'type',
            'parameters',
            'gridPosition',
            'dashboard',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'name',
            'type',
            'parameters',
            'gridPosition',
            'dashboard',
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

    public function setParameters(?array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getGridPosition(): ?array
    {
        return $this->gridPosition;
    }

    public function setGridPosition(array $gridPosition): self
    {
        $this->gridPosition = $gridPosition;

        return $this;
    }

    public function getDashboard(): ?Dashboard
    {
        return $this->dashboard;
    }

    public function setDashboard(?Dashboard $dashboard): self
    {
        $this->dashboard = $dashboard;

        return $this;
    }
}
