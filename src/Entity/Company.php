<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use App\Enumerator\CompanyType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class Company extends BaseEntity
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
     * @ORM\Column(type="CompanyType")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="companies")
     * @ORM\JoinColumn(name="companyId")
     */
    protected $company;

    /**
     * @ORM\OneToMany(targetEntity="Company", mappedBy="company")
     */
    protected $companies;

    /**
     * @ORM\OneToOne(targetEntity="LegalPerson", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="legalPersonId", nullable=false)
     */
    protected $legalPerson;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function toArray(array $options = [])
    {
        $array = parent::toArray($options);

        if ($this->checkOnlyExceptInArray('legalPerson', $options)) {
            $array['legalPerson'] = $this->legalPerson->toArray(isset($options['toArrayLegalPerson']) ? $options['toArrayLegalPerson'] : []);
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'type',
            'company',
            'companies',
            'legalPerson',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'type',
            'company',
            'legalPerson',
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

    public function getCompany(): ?self
    {
        return $this->company;
    }

    public function setCompany(?self $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(self $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setCompany($this);
        }

        return $this;
    }

    public function removeCompany(self $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getCompany() === $this) {
                $company->setCompany(null);
            }
        }

        return $this;
    }

    public function getLegalPerson(): ?LegalPerson
    {
        return $this->legalPerson;
    }

    public function setLegalPerson(LegalPerson $legalPerson): self
    {
        $this->legalPerson = $legalPerson;

        return $this;
    }
}
