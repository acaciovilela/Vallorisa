<?php

namespace DtlUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Rbac\Role\RoleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface, IdentityInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int 
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="display_name", type="string", length=255, nullable=true)
     * @var string 
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $state;

    /**
     * @ORM\OneToOne(targetEntity="UserProfile", cascade={"all"})
     * @var \DtlUser\Entity\UserProfile
     */
    protected $profile;

    /**
     * @ORM\ManyToMany(targetEntity="UserRole")
     * @var Collection
     */
    protected $roles;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var User
     */
    protected $parent;
    
    public function __construct() {
        $this->roles = new ArrayCollection();
        $this->profile = new UserProfile();
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getState() {
        return $this->state;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get user state
     * @param type $state
     * @return \DtlUser\Entity\User
     */
    public function setState($state) {
        $this->state = $state;
        return $this;
    }

    /**
     * Set a Profile to User
     * @param \DtlUser\Entity\UserProfile $profile
     * @return \DtlUser\Entity\User
     */
    public function setProfile(UserProfile $profile) {
        $this->profile = $profile;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles() {
        return $this->roles->toArray();
    }

    /**
     * @param Collection $roles
     */
    public function setRoles(Collection $roles) {
        $this->roles->clear();
        foreach ($roles as $role) {
            $this->roles[] = $role;
        }
    }

    /**
     * @param \Rbac\Role\RoleInterface $role
     */
    public function addRole(RoleInterface $role) {
        $this->roles[] = $role;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }
}
