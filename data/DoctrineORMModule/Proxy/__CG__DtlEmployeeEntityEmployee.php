<?php

namespace DoctrineORMModule\Proxy\__CG__\DtlEmployee\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Employee extends \DtlEmployee\Entity\Employee implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'admissionDate', 'demissionDate', 'workTime', 'ctps', 'ctpsSerie', 'pis', 'picture', 'salary', 'bonus', 'mark', 'timestamp', 'isActive', 'status', 'office', 'person', 'user', 'supplier', 'commissions', 'payments', 'company'];
        }

        return ['__isInitialized__', 'id', 'admissionDate', 'demissionDate', 'workTime', 'ctps', 'ctpsSerie', 'pis', 'picture', 'salary', 'bonus', 'mark', 'timestamp', 'isActive', 'status', 'office', 'person', 'user', 'supplier', 'commissions', 'payments', 'company'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Employee $proxy) {
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
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getAdmissionDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdmissionDate', []);

        return parent::getAdmissionDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getDemissionDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDemissionDate', []);

        return parent::getDemissionDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getWorkTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWorkTime', []);

        return parent::getWorkTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getCtps()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCtps', []);

        return parent::getCtps();
    }

    /**
     * {@inheritDoc}
     */
    public function getCtpsSerie()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCtpsSerie', []);

        return parent::getCtpsSerie();
    }

    /**
     * {@inheritDoc}
     */
    public function getPis()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPis', []);

        return parent::getPis();
    }

    /**
     * {@inheritDoc}
     */
    public function getPicture()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPicture', []);

        return parent::getPicture();
    }

    /**
     * {@inheritDoc}
     */
    public function getSalary()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSalary', []);

        return parent::getSalary();
    }

    /**
     * {@inheritDoc}
     */
    public function getBonus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBonus', []);

        return parent::getBonus();
    }

    /**
     * {@inheritDoc}
     */
    public function getMark()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMark', []);

        return parent::getMark();
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
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', []);

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function getCompany()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCompany', []);

        return parent::getCompany();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
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
    public function getPerson()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPerson', []);

        return parent::getPerson();
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
    public function getSupplier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSupplier', []);

        return parent::getSupplier();
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
    public function setAdmissionDate($admissionDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdmissionDate', [$admissionDate]);

        return parent::setAdmissionDate($admissionDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setDemissionDate($demissionDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDemissionDate', [$demissionDate]);

        return parent::setDemissionDate($demissionDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setWorkTime($workTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWorkTime', [$workTime]);

        return parent::setWorkTime($workTime);
    }

    /**
     * {@inheritDoc}
     */
    public function setCtps($ctps)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCtps', [$ctps]);

        return parent::setCtps($ctps);
    }

    /**
     * {@inheritDoc}
     */
    public function setCtpsSerie($ctpsSerie)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCtpsSerie', [$ctpsSerie]);

        return parent::setCtpsSerie($ctpsSerie);
    }

    /**
     * {@inheritDoc}
     */
    public function setPis($pis)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPis', [$pis]);

        return parent::setPis($pis);
    }

    /**
     * {@inheritDoc}
     */
    public function setPicture($picture)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPicture', [$picture]);

        return parent::setPicture($picture);
    }

    /**
     * {@inheritDoc}
     */
    public function setSalary($salary)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSalary', [$salary]);

        return parent::setSalary($salary);
    }

    /**
     * {@inheritDoc}
     */
    public function setBonus($bonus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBonus', [$bonus]);

        return parent::setBonus($bonus);
    }

    /**
     * {@inheritDoc}
     */
    public function setMark($mark)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMark', [$mark]);

        return parent::setMark($mark);
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
    public function setIsActive($isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', [$isActive]);

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function setCompany(\DtlCompany\Entity\Company $company)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCompany', [$company]);

        return parent::setCompany($company);
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(\DtlEmployeeStatus\Entity\EmployeeStatus $status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function setOffice(\DtlOffice\Entity\Office $office)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOffice', [$office]);

        return parent::setOffice($office);
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
    public function setUser(\DtlUser\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setSupplier(\DtlSupplier\Entity\Supplier $supplier)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSupplier', [$supplier]);

        return parent::setSupplier($supplier);
    }

    /**
     * {@inheritDoc}
     */
    public function getCommissions()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCommissions', []);

        return parent::getCommissions();
    }

    /**
     * {@inheritDoc}
     */
    public function addCommissions(\Doctrine\Common\Collections\Collection $commissions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCommissions', [$commissions]);

        return parent::addCommissions($commissions);
    }

    /**
     * {@inheritDoc}
     */
    public function removeCommissions(\Doctrine\Common\Collections\Collection $commissions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeCommissions', [$commissions]);

        return parent::removeCommissions($commissions);
    }

    /**
     * {@inheritDoc}
     */
    public function setCommissions($commissions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCommissions', [$commissions]);

        return parent::setCommissions($commissions);
    }

    /**
     * {@inheritDoc}
     */
    public function getPayments()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPayments', []);

        return parent::getPayments();
    }

    /**
     * {@inheritDoc}
     */
    public function setPayments($payments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPayments', [$payments]);

        return parent::setPayments($payments);
    }

    /**
     * {@inheritDoc}
     */
    public function addPayments(\Doctrine\Common\Collections\Collection $payments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPayments', [$payments]);

        return parent::addPayments($payments);
    }

    /**
     * {@inheritDoc}
     */
    public function removePayments(\Doctrine\Common\Collections\Collection $payments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePayments', [$payments]);

        return parent::removePayments($payments);
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
