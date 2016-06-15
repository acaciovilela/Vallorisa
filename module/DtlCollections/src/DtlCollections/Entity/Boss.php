<?php

namespace DtlCollections\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="boss")
 */
class Boss {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Master", cascade={"all"})
     * @var Master
     */
    protected $master;

    /**
     * @ORM\ManyToMany(targetEntity="Slave", cascade={"all"})
     * @ORM\JoinTable(name="boss_slave",
     *      joinColumns={@ORM\JoinColumn(name="boss_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="slave_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection
     */
    protected $slaves;

    public function __construct() {
        $this->master = new Master();
        $this->slaves = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getMaster() {
        return $this->master;
    }

    public function getSlaves() {
        return $this->slaves;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setMaster(Master $master) {
        $this->master = $master;
        return $this;
    }

    public function setSlaves(ArrayCollection $slaves) {
        $this->slaves = $slaves;
        return $this;
    }

    public function addSlaves(Collection $slaves) {
        foreach ($slaves as $slave) {
            $this->slaves->add($slave);
        }
    }

    public function addSlave($slave) {
        $this->slaves->add($slave);
        return $this;
    }

    public function removeSlaves(Collection $slaves) {
        foreach ($slaves as $slave) {
            $this->slaves->removeElement($slave);
        }
    }

}
