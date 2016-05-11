<?php

namespace DoctrineORMModule\Proxy\__CG__\DtlRealty\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class RealtyFeature extends \DtlRealty\Entity\RealtyFeature implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'builtArea', 'balconyArea', 'totalArea', 'usefulArea', 'groundArea', 'groundLength', 'groundWidth', 'bedroomAmount', 'roomAmount', 'suiteAmount', 'bathtubAmount', 'bathroomAmount', 'hallAmount', 'bathroomStall', 'bathroomCabinet', 'roomCabinet', 'restroom', 'livingRoom', 'doubleLiving', 'diningRoom', 'tvRoom', 'office', 'kitchen', 'plannedKitchen', 'storeRoom', 'serviceArea', 'storeHouse', 'liningSlab', 'pvcLiner', 'planking', 'finishPlaster', 'gasHeater', 'solarHeater'];
        }

        return ['__isInitialized__', 'id', 'builtArea', 'balconyArea', 'totalArea', 'usefulArea', 'groundArea', 'groundLength', 'groundWidth', 'bedroomAmount', 'roomAmount', 'suiteAmount', 'bathtubAmount', 'bathroomAmount', 'hallAmount', 'bathroomStall', 'bathroomCabinet', 'roomCabinet', 'restroom', 'livingRoom', 'doubleLiving', 'diningRoom', 'tvRoom', 'office', 'kitchen', 'plannedKitchen', 'storeRoom', 'serviceArea', 'storeHouse', 'liningSlab', 'pvcLiner', 'planking', 'finishPlaster', 'gasHeater', 'solarHeater'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (RealtyFeature $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getBuiltArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBuiltArea', []);

        return parent::getBuiltArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getBalconyArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBalconyArea', []);

        return parent::getBalconyArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotalArea', []);

        return parent::getTotalArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsefulArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsefulArea', []);

        return parent::getUsefulArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroundArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroundArea', []);

        return parent::getGroundArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroundLength()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroundLength', []);

        return parent::getGroundLength();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroundWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroundWidth', []);

        return parent::getGroundWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function getBedroomAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBedroomAmount', []);

        return parent::getBedroomAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoomAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoomAmount', []);

        return parent::getRoomAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getSuiteAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSuiteAmount', []);

        return parent::getSuiteAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getBathtubAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBathtubAmount', []);

        return parent::getBathtubAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getBathroomAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBathroomAmount', []);

        return parent::getBathroomAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getHallAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHallAmount', []);

        return parent::getHallAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getBathroomStall()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBathroomStall', []);

        return parent::getBathroomStall();
    }

    /**
     * {@inheritDoc}
     */
    public function getBathroomCabinet()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBathroomCabinet', []);

        return parent::getBathroomCabinet();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoomCabinet()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoomCabinet', []);

        return parent::getRoomCabinet();
    }

    /**
     * {@inheritDoc}
     */
    public function getRestroom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRestroom', []);

        return parent::getRestroom();
    }

    /**
     * {@inheritDoc}
     */
    public function getLivingRoom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLivingRoom', []);

        return parent::getLivingRoom();
    }

    /**
     * {@inheritDoc}
     */
    public function getDoubleLiving()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDoubleLiving', []);

        return parent::getDoubleLiving();
    }

    /**
     * {@inheritDoc}
     */
    public function getDiningRoom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDiningRoom', []);

        return parent::getDiningRoom();
    }

    /**
     * {@inheritDoc}
     */
    public function getTvRoom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTvRoom', []);

        return parent::getTvRoom();
    }

    /**
     * {@inheritDoc}
     */
    public function getOffice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOffice', []);

        return parent::getOffice();
    }

    /**
     * {@inheritDoc}
     */
    public function getKitchen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getKitchen', []);

        return parent::getKitchen();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlannedKitchen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlannedKitchen', []);

        return parent::getPlannedKitchen();
    }

    /**
     * {@inheritDoc}
     */
    public function getStoreRoom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStoreRoom', []);

        return parent::getStoreRoom();
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceArea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getServiceArea', []);

        return parent::getServiceArea();
    }

    /**
     * {@inheritDoc}
     */
    public function getStoreHouse()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStoreHouse', []);

        return parent::getStoreHouse();
    }

    /**
     * {@inheritDoc}
     */
    public function getLiningSlab()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLiningSlab', []);

        return parent::getLiningSlab();
    }

    /**
     * {@inheritDoc}
     */
    public function getPvcLiner()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPvcLiner', []);

        return parent::getPvcLiner();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlanking()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlanking', []);

        return parent::getPlanking();
    }

    /**
     * {@inheritDoc}
     */
    public function getFinishPlaster()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFinishPlaster', []);

        return parent::getFinishPlaster();
    }

    /**
     * {@inheritDoc}
     */
    public function getGasHeater()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGasHeater', []);

        return parent::getGasHeater();
    }

    /**
     * {@inheritDoc}
     */
    public function getSolarHeater()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSolarHeater', []);

        return parent::getSolarHeater();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setBuiltArea($builtArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBuiltArea', [$builtArea]);

        return parent::setBuiltArea($builtArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setBalconyArea($balconyArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBalconyArea', [$balconyArea]);

        return parent::setBalconyArea($balconyArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setTotalArea($totalArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTotalArea', [$totalArea]);

        return parent::setTotalArea($totalArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setUsefulArea($usefulArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsefulArea', [$usefulArea]);

        return parent::setUsefulArea($usefulArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setGroundArea($groundArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroundArea', [$groundArea]);

        return parent::setGroundArea($groundArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setGroundLength($groundLength)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroundLength', [$groundLength]);

        return parent::setGroundLength($groundLength);
    }

    /**
     * {@inheritDoc}
     */
    public function setGroundWidth($groundWidth)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroundWidth', [$groundWidth]);

        return parent::setGroundWidth($groundWidth);
    }

    /**
     * {@inheritDoc}
     */
    public function setBedroomAmount($bedroomAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBedroomAmount', [$bedroomAmount]);

        return parent::setBedroomAmount($bedroomAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setRoomAmount($roomAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRoomAmount', [$roomAmount]);

        return parent::setRoomAmount($roomAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setSuiteAmount($suiteAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSuiteAmount', [$suiteAmount]);

        return parent::setSuiteAmount($suiteAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setBathtubAmount($bathtubAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBathtubAmount', [$bathtubAmount]);

        return parent::setBathtubAmount($bathtubAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setBathroomAmount($bathroomAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBathroomAmount', [$bathroomAmount]);

        return parent::setBathroomAmount($bathroomAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setHallAmount($hallAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHallAmount', [$hallAmount]);

        return parent::setHallAmount($hallAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setBathroomStall($bathroomStall)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBathroomStall', [$bathroomStall]);

        return parent::setBathroomStall($bathroomStall);
    }

    /**
     * {@inheritDoc}
     */
    public function setBathroomCabinet($bathroomCabinet)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBathroomCabinet', [$bathroomCabinet]);

        return parent::setBathroomCabinet($bathroomCabinet);
    }

    /**
     * {@inheritDoc}
     */
    public function setRoomCabinet($roomCabinet)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRoomCabinet', [$roomCabinet]);

        return parent::setRoomCabinet($roomCabinet);
    }

    /**
     * {@inheritDoc}
     */
    public function setRestroom($restroom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRestroom', [$restroom]);

        return parent::setRestroom($restroom);
    }

    /**
     * {@inheritDoc}
     */
    public function setLivingRoom($livingRoom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLivingRoom', [$livingRoom]);

        return parent::setLivingRoom($livingRoom);
    }

    /**
     * {@inheritDoc}
     */
    public function setDoubleLiving($doubleLiving)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDoubleLiving', [$doubleLiving]);

        return parent::setDoubleLiving($doubleLiving);
    }

    /**
     * {@inheritDoc}
     */
    public function setDiningRoom($diningRoom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDiningRoom', [$diningRoom]);

        return parent::setDiningRoom($diningRoom);
    }

    /**
     * {@inheritDoc}
     */
    public function setTvRoom($tvRoom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTvRoom', [$tvRoom]);

        return parent::setTvRoom($tvRoom);
    }

    /**
     * {@inheritDoc}
     */
    public function setOffice($office)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOffice', [$office]);

        return parent::setOffice($office);
    }

    /**
     * {@inheritDoc}
     */
    public function setKitchen($kitchen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setKitchen', [$kitchen]);

        return parent::setKitchen($kitchen);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlannedKitchen($plannedKitchen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlannedKitchen', [$plannedKitchen]);

        return parent::setPlannedKitchen($plannedKitchen);
    }

    /**
     * {@inheritDoc}
     */
    public function setStoreRoom($storeRoom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStoreRoom', [$storeRoom]);

        return parent::setStoreRoom($storeRoom);
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceArea($serviceArea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setServiceArea', [$serviceArea]);

        return parent::setServiceArea($serviceArea);
    }

    /**
     * {@inheritDoc}
     */
    public function setStoreHouse($storeHouse)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStoreHouse', [$storeHouse]);

        return parent::setStoreHouse($storeHouse);
    }

    /**
     * {@inheritDoc}
     */
    public function setLiningSlab($liningSlab)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLiningSlab', [$liningSlab]);

        return parent::setLiningSlab($liningSlab);
    }

    /**
     * {@inheritDoc}
     */
    public function setPvcLiner($pvcLiner)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPvcLiner', [$pvcLiner]);

        return parent::setPvcLiner($pvcLiner);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlanking($planking)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlanking', [$planking]);

        return parent::setPlanking($planking);
    }

    /**
     * {@inheritDoc}
     */
    public function setFinishPlaster($finishPlaster)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFinishPlaster', [$finishPlaster]);

        return parent::setFinishPlaster($finishPlaster);
    }

    /**
     * {@inheritDoc}
     */
    public function setGasHeater($gasHeater)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGasHeater', [$gasHeater]);

        return parent::setGasHeater($gasHeater);
    }

    /**
     * {@inheritDoc}
     */
    public function setSolarHeater($solarHeater)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSolarHeater', [$solarHeater]);

        return parent::setSolarHeater($solarHeater);
    }

}