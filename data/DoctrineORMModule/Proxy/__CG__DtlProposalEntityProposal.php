<?php

namespace DoctrineORMModule\Proxy\__CG__\DtlProposal\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Proposal extends \DtlProposal\Entity\Proposal implements \Doctrine\ORM\Proxy\Proxy
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
    public static $lazyPropertiesDefaults = array();



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
            return array('__isInitialized__', 'id', 'number', 'value', 'parcelAmount', 'parcelValue', 'date', 'baseDate', 'startDate', 'endDate', 'commission', 'isActive', 'isApproved', 'isIntegrated', 'isRefused', 'isCanceled', 'isChecking', 'isAborted', 'isPending', 'lastChange', 'timestamp', 'notes', 'bank', 'employee', 'customer', 'company', 'logs', 'reports', 'files', 'user');
        }

        return array('__isInitialized__', 'id', 'number', 'value', 'parcelAmount', 'parcelValue', 'date', 'baseDate', 'startDate', 'endDate', 'commission', 'isActive', 'isApproved', 'isIntegrated', 'isRefused', 'isCanceled', 'isChecking', 'isAborted', 'isPending', 'lastChange', 'timestamp', 'notes', 'bank', 'employee', 'customer', 'company', 'logs', 'reports', 'files', 'user');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Proposal $proxy) {
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
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
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


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumber', array());

        return parent::getNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValue', array());

        return parent::getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getParcelAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParcelAmount', array());

        return parent::getParcelAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getParcelValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParcelValue', array());

        return parent::getParcelValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDate', array());

        return parent::getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBaseDate', array());

        return parent::getBaseDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getStartDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStartDate', array());

        return parent::getStartDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getEndDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEndDate', array());

        return parent::getEndDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getCommission()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCommission', array());

        return parent::getCommission();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', array());

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsApproved()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsApproved', array());

        return parent::getIsApproved();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsIntegrated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsIntegrated', array());

        return parent::getIsIntegrated();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsRefused()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsRefused', array());

        return parent::getIsRefused();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsCanceled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsCanceled', array());

        return parent::getIsCanceled();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsChecking()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsChecking', array());

        return parent::getIsChecking();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsAborted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsAborted', array());

        return parent::getIsAborted();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsPending()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsPending', array());

        return parent::getIsPending();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastChange()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastChange', array());

        return parent::getLastChange();
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTimestamp', array());

        return parent::getTimestamp();
    }

    /**
     * {@inheritDoc}
     */
    public function getNotes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotes', array());

        return parent::getNotes();
    }

    /**
     * {@inheritDoc}
     */
    public function getBank()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBank', array());

        return parent::getBank();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmployee()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmployee', array());

        return parent::getEmployee();
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomer()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomer', array());

        return parent::getCustomer();
    }

    /**
     * {@inheritDoc}
     */
    public function getCompany()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCompany', array());

        return parent::getCompany();
    }

    /**
     * {@inheritDoc}
     */
    public function getLogs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLogs', array());

        return parent::getLogs();
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', array());

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setNumber($number)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumber', array($number));

        return parent::setNumber($number);
    }

    /**
     * {@inheritDoc}
     */
    public function setValue($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setValue', array($value));

        return parent::setValue($value);
    }

    /**
     * {@inheritDoc}
     */
    public function setParcelAmount($parcelAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParcelAmount', array($parcelAmount));

        return parent::setParcelAmount($parcelAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function setParcelValue($parcelValue)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParcelValue', array($parcelValue));

        return parent::setParcelValue($parcelValue);
    }

    /**
     * {@inheritDoc}
     */
    public function setDate($date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDate', array($date));

        return parent::setDate($date);
    }

    /**
     * {@inheritDoc}
     */
    public function setBaseDate($baseDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBaseDate', array($baseDate));

        return parent::setBaseDate($baseDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setStartDate($startDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStartDate', array($startDate));

        return parent::setStartDate($startDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setEndDate($endDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEndDate', array($endDate));

        return parent::setEndDate($endDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setCommission($commission)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCommission', array($commission));

        return parent::setCommission($commission);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsActive($isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', array($isActive));

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsApproved($isApproved)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsApproved', array($isApproved));

        return parent::setIsApproved($isApproved);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsIntegrated($isIntegrated)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsIntegrated', array($isIntegrated));

        return parent::setIsIntegrated($isIntegrated);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsRefused($isRefused)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsRefused', array($isRefused));

        return parent::setIsRefused($isRefused);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsCanceled($isCanceled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsCanceled', array($isCanceled));

        return parent::setIsCanceled($isCanceled);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsChecking($isChecking)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsChecking', array($isChecking));

        return parent::setIsChecking($isChecking);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsAborted($isAborted)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsAborted', array($isAborted));

        return parent::setIsAborted($isAborted);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsPending($isPending)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsPending', array($isPending));

        return parent::setIsPending($isPending);
    }

    /**
     * {@inheritDoc}
     */
    public function setLastChange($lastChange)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastChange', array($lastChange));

        return parent::setLastChange($lastChange);
    }

    /**
     * {@inheritDoc}
     */
    public function setTimestamp($timestamp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTimestamp', array($timestamp));

        return parent::setTimestamp($timestamp);
    }

    /**
     * {@inheritDoc}
     */
    public function setNotes($notes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotes', array($notes));

        return parent::setNotes($notes);
    }

    /**
     * {@inheritDoc}
     */
    public function setBank(\DtlBank\Entity\Bank $bank)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBank', array($bank));

        return parent::setBank($bank);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmployee(\DtlEmployee\Entity\Employee $employee)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmployee', array($employee));

        return parent::setEmployee($employee);
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomer(\DtlCustomer\Entity\Customer $customer)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustomer', array($customer));

        return parent::setCustomer($customer);
    }

    /**
     * {@inheritDoc}
     */
    public function setCompany(\DtlCompany\Entity\Company $company)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCompany', array($company));

        return parent::setCompany($company);
    }

    /**
     * {@inheritDoc}
     */
    public function setLogs(\Doctrine\Common\Collections\ArrayCollection $logs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLogs', array($logs));

        return parent::setLogs($logs);
    }

    /**
     * {@inheritDoc}
     */
    public function addLog($log)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLog', array($log));

        return parent::addLog($log);
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\DtlUser\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', array($user));

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getReports()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReports', array());

        return parent::getReports();
    }

    /**
     * {@inheritDoc}
     */
    public function addReport($report)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addReport', array($report));

        return parent::addReport($report);
    }

    /**
     * {@inheritDoc}
     */
    public function setReports($reports)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReports', array($reports));

        return parent::setReports($reports);
    }

    /**
     * {@inheritDoc}
     */
    public function getFiles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFiles', array());

        return parent::getFiles();
    }

    /**
     * {@inheritDoc}
     */
    public function addFile($file)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFile', array($file));

        return parent::addFile($file);
    }

    /**
     * {@inheritDoc}
     */
    public function removeFile($file)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeFile', array($file));

        return parent::removeFile($file);
    }

    /**
     * {@inheritDoc}
     */
    public function setFiles($files)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFiles', array($files));

        return parent::setFiles($files);
    }

}
