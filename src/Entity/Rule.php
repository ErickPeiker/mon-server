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
 * @ORM\Entity(repositoryClass="App\Repository\RuleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Rule extends BaseEntity
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
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Company", cascade={"persist"})
     * @ORM\JoinColumn(name="companyId", nullable=false)
     */
    protected $company;

    /**
     * @ORM\OneToMany(targetEntity="Criteria", mappedBy="rule", orphanRemoval=true)
     */
    protected $criterias;

    public function __construct()
    {
        $this->criterias = new ArrayCollection();
    }

    public function toArray(array $options = [])
    {
        $array = parent::toArray();

        if ($this->checkOnlyExceptInArray('criterias', $options)) {
            $array['criterias'] = [];
            foreach ($this->criterias as $criteria) {
                $array['criterias'][] = $criteria->toArray(isset($options['toArrayCriterias']) ? $options['toArrayCriterias'] : []);
            }
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'name',
            'isActive',
            'company',
            'criterias',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'name',
            'isActive',
            'company',
            'criterias',
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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Criteria[]
     */
    public function getCriterias(): Collection
    {
        return $this->criterias;
    }

    public function addCriteria(Criteria $criteria): self
    {
        if (!$this->criterias->contains($criteria)) {
            $this->criterias[] = $criteria;
            $criteria->setRule($this);
        }

        return $this;
    }

    public function removeCriteria(Criteria $criteria): self
    {
        if ($this->criterias->contains($criteria)) {
            $this->criterias->removeElement($criteria);
            // set the owning side to null (unless already changed)
            if ($criteria->getRule() === $this) {
                $criteria->setRule(null);
            }
        }

        return $this;
    }
}
