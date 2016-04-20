<?php

namespace DtlVehicle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehicle_type")
 */
class VehicleType {

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
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleBrand", cascade={"persist"})
     * @var VehicleBrand
     */
    protected $brand;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setBrand(VehicleBrand $brand) {
        $this->brand = $brand;
        return $this;
    }

}
