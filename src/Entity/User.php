<?php

namespace App\Entity;

use App\Base\Doctrine\ORM\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`User`")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable()
 */
class User extends BaseEntity implements UserInterface
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;
    protected $plainPassword;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $apiToken;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="PhysicalPerson", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="physicalPersonId", nullable=true)
     */
    protected $physicalPerson;

    /**
     * @ORM\ManyToOne(targetEntity="Company", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="companyId", nullable=false)
     */
    protected $company;

    /**
     * @ORM\ManyToMany(targetEntity="Company", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="UserCompany",
     *     joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="companyId", referencedColumnName="id")}
     * )
     */
    protected $companies;

    /**
     * @ORM\ManyToMany(targetEntity="Group", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="UserGroup",
     *     joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="groupId", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\ManyToOne(targetEntity="Dashboard", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="dashboardId")
     */
    protected $dashboard;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function toArray(array $options = [])
    {
        $array = parent::toArray($options);

        if ($this->checkOnlyExceptInArray('company', $options) && $this->company) {
            $array['company'] = $this->company->toArray(isset($options['toArrayCompany']) ? $options['toArrayCompany'] : []);
        }

        if ($this->checkOnlyExceptInArray('physicalPerson', $options) && $this->physicalPerson) {
            $array['physicalPerson'] = $this->physicalPerson->toArray(isset($options['toArrayPhysicalPerson']) ? $options['toArrayPhysicalPerson'] : []);
        }

        return $array;
    }

    protected function getFillable()
    {
        return [
            'id',
            'email',
            'roles',
            'physicalPerson',
            'company',
            'companies',
            'groups',
            'dashboard',
            'createdAt',
            'updatedAt',
            'deletedAt',
        ];
    }

    public function getOnlyStore()
    {
        return [
            'email',
            'plainPassword',
            'roles',
            'physicalPerson',
            'company',
            'companies',
            'groups',
            'dashboard',
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPhysicalPerson(): ?PhysicalPerson
    {
        return $this->physicalPerson;
    }

    public function setPhysicalPerson(?PhysicalPerson $physicalPerson): self
    {
        $this->physicalPerson = $physicalPerson;

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
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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
