<?php

namespace DtlOffice\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="office")
 */
class Office {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
}
