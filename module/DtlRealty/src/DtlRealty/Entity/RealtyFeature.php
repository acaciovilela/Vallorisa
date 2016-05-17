<?php

namespace DtlRealty\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realty_feature")
 */
class RealtyFeature {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="built_area", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $builtArea;

    /**
     * @ORM\Column(name="balcony_area", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $balconyArea;

    /**
     * @ORM\Column(name="total_area", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $totalArea;

    /**
     * @ORM\Column(name="useful_area", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $usefulArea;

    /**
     * @ORM\Column(name="ground_area", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $groundArea;

    /**
     * @ORM\Column(name="ground_length", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $groundLength;

    /**
     * @ORM\Column(name="ground_width", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $groundWidth;

    /**
     * @ORM\Column(name="bedroom_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $bedroomAmount;

    /**
     * @ORM\Column(name="room_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $roomAmount;

    /**
     * @ORM\Column(name="suite_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $suiteAmount;

    /**
     * @ORM\Column(name="bathtub_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $bathtubAmount;

    /**
     * @ORM\Column(name="bathroom_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $bathroomAmount;

    /**
     * @ORM\Column(name="hall_amount", type="integer", nullable=true)
     * @var integer
     */
    protected $hallAmount;

    /**
     * @ORM\Column(name="bathroom_stall", type="boolean", nullable=true)
     * @var boolean
     */
    protected $bathroomStall;

    /**
     * @ORM\Column(name="bathroom_cabinet", type="boolean", nullable=true)
     * @var boolean
     */
    protected $bathroomCabinet;

    /**
     * @ORM\Column(name="room_cabinet", type="boolean", nullable=true)
     * @var boolean
     */
    protected $roomCabinet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $restroom;

    /**
     * @ORM\Column(name="living_room", type="boolean", nullable=true)
     * @var boolean
     */
    protected $livingRoom;

    /**
     * @ORM\Column(name="double_living", type="boolean", nullable=true)
     * @var boolean
     */
    protected $doubleLiving;

    /**
     * @ORM\Column(name="dining_room", type="boolean", nullable=true)
     * @var boolean
     */
    protected $diningRoom;

    /**
     * @ORM\Column(name="tv_room", type="boolean", nullable=true)
     * @var boolean
     */
    protected $tvRoom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $office;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $kitchen;

    /**
     * @ORM\Column(name="planned_kitchen", type="boolean", nullable=true)
     * @var boolean
     */
    protected $plannedKitchen;

    /**
     * @ORM\Column(name="store_room", type="boolean", nullable=true)
     * @var boolean
     */
    protected $storeRoom;

    /**
     * @ORM\Column(name="service_area", type="boolean", nullable=true)
     * @var boolean
     */
    protected $serviceArea;

    /**
     * @ORM\Column(name="store_house", type="boolean", nullable=true)
     * @var boolean
     */
    protected $storeHouse;

    /**
     * @ORM\Column(name="lining_slab", type="boolean", nullable=true)
     * @var boolean
     */
    protected $liningSlab;

    /**
     * @ORM\Column(name="pvc_liner", type="boolean", nullable=true)
     * @var boolean
     */
    protected $pvcLiner;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $planking;

    /**
     * @ORM\Column(name="finish_plaster", type="boolean", nullable=true)
     * @var boolean
     */
    protected $finishPlaster;

    /**
     * @ORM\Column(name="gas_heater", type="boolean", nullable=true)
     * @var boolean
     */
    protected $gasHeater;

    /**
     * @ORM\Column(name="solar_heater", type="boolean", nullable=true)
     * @var boolean
     */
    protected $solarHeater;

    public function __construct() {
        $this->builtArea = 0;
        $this->balconyArea = 0;
        $this->totalArea = 0;
        $this->groundArea = 0;
        $this->groundLength = 0;
        $this->groundWidth = 0;
        $this->usefulArea = 0;
        $this->bedroomAmount = 0;
        $this->roomAmount = 0;
        $this->suiteAmount = 0;
        $this->bathtubAmount = 0;
        $this->bathroomAmount = 0;
        $this->hallAmount = 0;
        $this->bathroomStall = false;
        $this->bathroomCabinet = false;
        $this->roomCabinet = false;
        $this->restroom = false;
        $this->livingRoom = false;
        $this->doubleLiving = false;
        $this->diningRoom = false;
        $this->tvRoom = false;
        $this->office = false;
        $this->kitchen = false;
        $this->plannedKitchen = false;
        $this->storeRoom = false;
        $this->serviceArea = false;
        $this->storeHouse = false;
        $this->liningSlab = false;
        $this->pvcLiner = false;
        $this->planking = false;
        $this->finishPlaster = false;
        $this->gasHeater = false;
        $this->solarHeater = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getBuiltArea() {
        return $this->builtArea;
    }

    public function getBalconyArea() {
        return $this->balconyArea;
    }

    public function getTotalArea() {
        return $this->totalArea;
    }

    public function getUsefulArea() {
        return $this->usefulArea;
    }

    public function getGroundArea() {
        return $this->groundArea;
    }

    public function getGroundLength() {
        return $this->groundLength;
    }

    public function getGroundWidth() {
        return $this->groundWidth;
    }

    public function getBedroomAmount() {
        return $this->bedroomAmount;
    }

    public function getRoomAmount() {
        return $this->roomAmount;
    }

    public function getSuiteAmount() {
        return $this->suiteAmount;
    }

    public function getBathtubAmount() {
        return $this->bathtubAmount;
    }

    public function getBathroomAmount() {
        return $this->bathroomAmount;
    }

    public function getHallAmount() {
        return $this->hallAmount;
    }

    public function getBathroomStall() {
        return $this->bathroomStall;
    }

    public function getBathroomCabinet() {
        return $this->bathroomCabinet;
    }

    public function getRoomCabinet() {
        return $this->roomCabinet;
    }

    public function getRestroom() {
        return $this->restroom;
    }

    public function getLivingRoom() {
        return $this->livingRoom;
    }

    public function getDoubleLiving() {
        return $this->doubleLiving;
    }

    public function getDiningRoom() {
        return $this->diningRoom;
    }

    public function getTvRoom() {
        return $this->tvRoom;
    }

    public function getOffice() {
        return $this->office;
    }

    public function getKitchen() {
        return $this->kitchen;
    }

    public function getPlannedKitchen() {
        return $this->plannedKitchen;
    }

    public function getStoreRoom() {
        return $this->storeRoom;
    }

    public function getServiceArea() {
        return $this->serviceArea;
    }

    public function getStoreHouse() {
        return $this->storeHouse;
    }

    public function getLiningSlab() {
        return $this->liningSlab;
    }

    public function getPvcLiner() {
        return $this->pvcLiner;
    }

    public function getPlanking() {
        return $this->planking;
    }

    public function getFinishPlaster() {
        return $this->finishPlaster;
    }

    public function getGasHeater() {
        return $this->gasHeater;
    }

    public function getSolarHeater() {
        return $this->solarHeater;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setBuiltArea($builtArea) {
        $this->builtArea = $builtArea;
        return $this;
    }

    public function setBalconyArea($balconyArea) {
        $this->balconyArea = $balconyArea;
        return $this;
    }

    public function setTotalArea($totalArea) {
        $this->totalArea = $totalArea;
        return $this;
    }

    public function setUsefulArea($usefulArea) {
        $this->usefulArea = $usefulArea;
        return $this;
    }

    public function setGroundArea($groundArea) {
        $this->groundArea = $groundArea;
        return $this;
    }

    public function setGroundLength($groundLength) {
        $this->groundLength = $groundLength;
        return $this;
    }

    public function setGroundWidth($groundWidth) {
        $this->groundWidth = $groundWidth;
        return $this;
    }

    public function setBedroomAmount($bedroomAmount) {
        $this->bedroomAmount = $bedroomAmount;
        return $this;
    }

    public function setRoomAmount($roomAmount) {
        $this->roomAmount = $roomAmount;
        return $this;
    }

    public function setSuiteAmount($suiteAmount) {
        $this->suiteAmount = $suiteAmount;
        return $this;
    }

    public function setBathtubAmount($bathtubAmount) {
        $this->bathtubAmount = $bathtubAmount;
        return $this;
    }

    public function setBathroomAmount($bathroomAmount) {
        $this->bathroomAmount = $bathroomAmount;
        return $this;
    }

    public function setHallAmount($hallAmount) {
        $this->hallAmount = $hallAmount;
        return $this;
    }

    public function setBathroomStall($bathroomStall) {
        $this->bathroomStall = $bathroomStall;
        return $this;
    }

    public function setBathroomCabinet($bathroomCabinet) {
        $this->bathroomCabinet = $bathroomCabinet;
        return $this;
    }

    public function setRoomCabinet($roomCabinet) {
        $this->roomCabinet = $roomCabinet;
        return $this;
    }

    public function setRestroom($restroom) {
        $this->restroom = $restroom;
        return $this;
    }

    public function setLivingRoom($livingRoom) {
        $this->livingRoom = $livingRoom;
        return $this;
    }

    public function setDoubleLiving($doubleLiving) {
        $this->doubleLiving = $doubleLiving;
        return $this;
    }

    public function setDiningRoom($diningRoom) {
        $this->diningRoom = $diningRoom;
        return $this;
    }

    public function setTvRoom($tvRoom) {
        $this->tvRoom = $tvRoom;
        return $this;
    }

    public function setOffice($office) {
        $this->office = $office;
        return $this;
    }

    public function setKitchen($kitchen) {
        $this->kitchen = $kitchen;
        return $this;
    }

    public function setPlannedKitchen($plannedKitchen) {
        $this->plannedKitchen = $plannedKitchen;
        return $this;
    }

    public function setStoreRoom($storeRoom) {
        $this->storeRoom = $storeRoom;
        return $this;
    }

    public function setServiceArea($serviceArea) {
        $this->serviceArea = $serviceArea;
        return $this;
    }

    public function setStoreHouse($storeHouse) {
        $this->storeHouse = $storeHouse;
        return $this;
    }

    public function setLiningSlab($liningSlab) {
        $this->liningSlab = $liningSlab;
        return $this;
    }

    public function setPvcLiner($pvcLiner) {
        $this->pvcLiner = $pvcLiner;
        return $this;
    }

    public function setPlanking($planking) {
        $this->planking = $planking;
        return $this;
    }

    public function setFinishPlaster($finishPlaster) {
        $this->finishPlaster = $finishPlaster;
        return $this;
    }

    public function setGasHeater($gasHeater) {
        $this->gasHeater = $gasHeater;
        return $this;
    }

    public function setSolarHeater($solarHeater) {
        $this->solarHeater = $solarHeater;
        return $this;
    }

}
