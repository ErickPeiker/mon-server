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
 * @ORM\Entity(repositoryClass="App\Repository\CriteriaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Criteria extends BaseEntity
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
    protected $templateCriteria;

    /**
     * @ORM\ManyToOne(targetEntity="Rule", inversedBy="criterias", cascade={"persist"})
     * @ORM\JoinColumn(name="ruleId", nullable=false)
     */
    protected $rule;

    /**
     * @ORM\OneToMany(targetEntity="Action", mappedBy="criteria", orphanRemoval=true)
     */
    protected $actions;

    /**
     * @ORM\OneToMany(targetEntity="Expression", mappedBy="criteria", orphanRemoval=true)
     */
    protected $expressions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->expressions = new ArrayCollection();
    }

    public function toArray(array $options = [])
    {
        $array = parent::toArray();

        if ($this->checkOnlyExceptInArray('actions', $options)) {
            $array['actions'] = [];
            foreach ($this->actions as $action) {
                $array['actions'][] = $action->toArray(isset($options['toArrayCriteria']) ? $options['toArrayCriteria'] : []);
            }
        }

        if ($this->checkOnlyExceptInArray('expressions', $options)) {
            $array['expressions'] = [];
            foreach ($this->expressions as $expression) {
                $array['expressions'][] = $expression->toArray(isset($options['toArrayCriteria']) ? $options['toArrayCriteria'] : []);
            }
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'templateCriteria',
            'rule',
            'actions',
            'expressions',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'templateCriteria',
            'rule',
            'actions',
            'expressions',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTemplateCriteria(): ?string
    {
        return $this->templateCriteria;
    }

    public function setTemplateCriteria(string $templateCriteria): self
    {
        $this->templateCriteria = $templateCriteria;

        return $this;
    }

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function setRule(?Rule $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setCriteria($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getCriteria() === $this) {
                $action->setCriteria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Expression[]
     */
    public function getExpressions(): Collection
    {
        return $this->expressions;
    }

    public function addExpression(Expression $expression): self
    {
        if (!$this->expressions->contains($expression)) {
            $this->expressions[] = $expression;
            $expression->setCriteria($this);
        }

        return $this;
    }

    public function removeExpression(Expression $expression): self
    {
        if ($this->expressions->contains($expression)) {
            $this->expressions->removeElement($expression);
            // set the owning side to null (unless already changed)
            if ($expression->getCriteria() === $this) {
                $expression->setCriteria(null);
            }
        }

        return $this;
    }
}
