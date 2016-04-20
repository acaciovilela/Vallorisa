<?php

namespace DtlVehicle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehicle")
 */
class Vehicle {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $year;

    /**
     * @ORM\Column(name="year_model", type="string", nullable=true)
     * @var string
     */
    protected $yearModel;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $plate;

    /**
     * @ORM\Column(name="plate_uf", type="string", nullable=true)
     * @var string
     */
    protected $plateUf;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $color;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $fuel;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $frame;

    /**
     * @ORM\Column(name="frame_type", type="string", nullable=true)
     * @var string
     */
    protected $frameType;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $renavam;

    /**
     * @ORM\Column(name="licence_uf", type="string", nullable=true)
     * @var string
     */
    protected $licenceUf;

    /**
     * @ORM\Column(name="owner_type", type="string", nullable=true)
     * @var string
     */
    protected $ownerType;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    protected $value;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $notes;

    /**
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleBrand", cascade="persist")
     * @var VehicleBrand
     */
    protected $brand;

    /**
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleType", cascade="persist")
     * @var VehicleType
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleModel", cascade="persist")
     * @var VehicleModel
     */
    protected $model;

    /**
     * @ORM\ManyToOne(targetEntity="DtlVehicle\Entity\VehicleVersion", cascade="persist")
     * @var VehicleVersion 
     */
    protected $version;

    public function __construct() {
        $this->value = 0.00;
    }

    public function getId() {
        return $this->id;
    }

    public function getYear() {
        return $this->year;
    }

    public function getYearModel() {
        return $this->yearModel;
    }

    public function getPlate() {
        return $this->plate;
    }

    public function getPlateUf() {
        return $this->plateUf;
    }

    public function getColor() {
        return $this->color;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getFuel() {
        return $this->fuel;
    }

    public function getFrame() {
        return $this->frame;
    }

    public function getFrameType() {
        return $this->frameType;
    }

    public function getRenavam() {
        return $this->renavam;
    }

    public function getLicenceUf() {
        return $this->licenceUf;
    }

    public function getOwnerType() {
        return $this->ownerType;
    }

    public function getValue() {
        return $this->value;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getType() {
        return $this->type;
    }

    public function getModel() {
        return $this->model;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setYear($year) {
        $this->year = $year;
        return $this;
    }

    public function setYearModel($yearModel) {
        $this->yearModel = $yearModel;
        return $this;
    }

    public function setPlate($plate) {
        $this->plate = $plate;
        return $this;
    }

    public function setPlateUf($plateUf) {
        $this->plateUf = $plateUf;
        return $this;
    }

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setFuel($fuel) {
        $this->fuel = $fuel;
        return $this;
    }

    public function setFrame($frame) {
        $this->frame = $frame;
        return $this;
    }

    public function setFrameType($frameType) {
        $this->frameType = $frameType;
        return $this;
    }

    public function setRenavam($renavam) {
        $this->renavam = $renavam;
        return $this;
    }

    public function setLicenceUf($licenceUf) {
        $this->licenceUf = $licenceUf;
        return $this;
    }

    public function setOwnerType($ownerType) {
        $this->ownerType = $ownerType;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setBrand(VehicleBrand $brand) {
        $this->brand = $brand;
        return $this;
    }

    public function setType(VehicleType $type) {
        $this->type = $type;
        return $this;
    }

    public function setModel(VehicleModel $model) {
        $this->model = $model;
        return $this;
    }

    public function setVersion(VehicleVersion $version) {
        $this->version = $version;
        return $this;
    }

}
