<?php

namespace DtlVehicle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehicle_version")
 */
class VehicleVersion {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleModel", cascade={"persist"})
     * @var VehicleModel
     */
    protected $model;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getModel() {
        return $this->model;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setModel(VehicleModel $model) {
        $this->model = $model;
        return $this;
    }

}
