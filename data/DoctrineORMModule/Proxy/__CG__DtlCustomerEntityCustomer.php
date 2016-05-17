<?php

namespace DoctrineORMModule\Proxy\__CG__\DtlCustomer\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Customer extends \DtlCustomer\Entity\Customer implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'isActive', 'timestamp', 'residenceTime', 'residenceType', 'residenceRentValue', 'notes', 'user', 'person', 'references', 'patrimonies', 'accounts', 'vehicles'];
        }

        return ['__isInitialized__', 'id', 'isActive', 'timestamp', 'residenceTime', 'residenceType', 'residenceRentValue', 'notes', 'user', 'person', 'references', 'patrimonies', 'accounts', 'vehicles'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Customer $proxy) {
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
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', []);

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTimestamp', []);

        return parent::getTimestamp();
    }

    /**
     * {@inheritDoc}
     */
    public function getResidenceTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResidenceTime', []);

        return parent::getResidenceTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getResidenceType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResidenceType', []);

        return parent::getResidenceType();
    }

    /**
     * {@inheritDoc}
     */
    public function getResidenceRentValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResidenceRentValue', []);

        return parent::getResidenceRentValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getNotes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotes', []);

        return parent::getNotes();
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function getPerson()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPerson', []);

        return parent::getPerson();
    }

    /**
     * {@inheritDoc}
     */
    public function getReferences()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReferences', []);

        return parent::getReferences();
    }

    /**
     * {@inheritDoc}
     */
    public function getPatrimonies()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPatrimonies', []);

        return parent::getPatrimonies();
    }

    /**
     * {@inheritDoc}
     */
    public function getAccounts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAccounts', []);

        return parent::getAccounts();
    }

    /**
     * {@inheritDoc}
     */
    public function getVehicles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVehicles', []);

        return parent::getVehicles();
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
    public function setIsActive($isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', [$isActive]);

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function setTimestamp($timestamp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTimestamp', [$timestamp]);

        return parent::setTimestamp($timestamp);
    }

    /**
     * {@inheritDoc}
     */
    public function setResidenceTime($residenceTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResidenceTime', [$residenceTime]);

        return parent::setResidenceTime($residenceTime);
    }

    /**
     * {@inheritDoc}
     */
    public function setResidenceType($residenceType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResidenceType', [$residenceType]);

        return parent::setResidenceType($residenceType);
    }

    /**
     * {@inheritDoc}
     */
    public function setResidenceRentValue($residenceRentValue)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResidenceRentValue', [$residenceRentValue]);

        return parent::setResidenceRentValue($residenceRentValue);
    }

    /**
     * {@inheritDoc}
     */
    public function setNotes($notes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotes', [$notes]);

        return parent::setNotes($notes);
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\DtlUser\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setPerson(\DtlPerson\Entity\Person $person)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPerson', [$person]);

        return parent::setPerson($person);
    }

    /**
     * {@inheritDoc}
     */
    public function setReferences(\Doctrine\Common\Collections\ArrayCollection $references)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReferences', [$references]);

        return parent::setReferences($references);
    }

    /**
     * {@inheritDoc}
     */
    public function addReference($reference)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addReference', [$reference]);

        return parent::addReference($reference);
    }

    /**
     * {@inheritDoc}
     */
    public function setPatrimonies(\Doctrine\Common\Collections\ArrayCollection $patrimonies)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPatrimonies', [$patrimonies]);

        return parent::setPatrimonies($patrimonies);
    }

    /**
     * {@inheritDoc}
     */
    public function addPatrimony($patrimony)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPatrimony', [$patrimony]);

        return parent::addPatrimony($patrimony);
    }

    /**
     * {@inheritDoc}
     */
    public function setAccounts(\Doctrine\Common\Collections\ArrayCollection $accounts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAccounts', [$accounts]);

        return parent::setAccounts($accounts);
    }

    /**
     * {@inheritDoc}
     */
    public function addAccount($account)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAccount', [$account]);

        return parent::addAccount($account);
    }

    /**
     * {@inheritDoc}
     */
    public function setVehicles(\Doctrine\Common\Collections\ArrayCollection $vehicles)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVehicles', [$vehicles]);

        return parent::setVehicles($vehicles);
    }

    /**
     * {@inheritDoc}
     */
    public function addVehicle($vehicle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addVehicle', [$vehicle]);

        return parent::addVehicle($vehicle);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

}
