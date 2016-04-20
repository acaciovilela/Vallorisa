<?php

namespace DoctrineORMModule\Proxy\__CG__\DtlFinancial\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Account extends \DtlFinancial\Entity\Account implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'description', 'number', 'emissionDate', 'expirationDate', 'value', 'parcels', 'currentParcel', 'barcode', 'autoLaunch', 'fine', 'interest', 'interestInterval', 'notes', 'datetime', 'done', 'doneDate', 'doneValue', 'isRecurrent', 'recurrenceInterval', 'currentAccount', 'paymentType', 'accountingItem', 'documentType');
        }

        return array('__isInitialized__', 'id', 'description', 'number', 'emissionDate', 'expirationDate', 'value', 'parcels', 'currentParcel', 'barcode', 'autoLaunch', 'fine', 'interest', 'interestInterval', 'notes', 'datetime', 'done', 'doneDate', 'doneValue', 'isRecurrent', 'recurrenceInterval', 'currentAccount', 'paymentType', 'accountingItem', 'documentType');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Account $proxy) {
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
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
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
    public function getEmissionDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmissionDate', array());

        return parent::getEmissionDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getExpirationDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExpirationDate', array());

        return parent::getExpirationDate();
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
    public function getParcels()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParcels', array());

        return parent::getParcels();
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentParcel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurrentParcel', array());

        return parent::getCurrentParcel();
    }

    /**
     * {@inheritDoc}
     */
    public function getBarcode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBarcode', array());

        return parent::getBarcode();
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoLaunch()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAutoLaunch', array());

        return parent::getAutoLaunch();
    }

    /**
     * {@inheritDoc}
     */
    public function getFine()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFine', array());

        return parent::getFine();
    }

    /**
     * {@inheritDoc}
     */
    public function getInterest()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInterest', array());

        return parent::getInterest();
    }

    /**
     * {@inheritDoc}
     */
    public function getInterestInterval()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInterestInterval', array());

        return parent::getInterestInterval();
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
    public function getDatetime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatetime', array());

        return parent::getDatetime();
    }

    /**
     * {@inheritDoc}
     */
    public function getDone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDone', array());

        return parent::getDone();
    }

    /**
     * {@inheritDoc}
     */
    public function getDoneDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDoneDate', array());

        return parent::getDoneDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getDoneValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDoneValue', array());

        return parent::getDoneValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsRecurrent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsRecurrent', array());

        return parent::getIsRecurrent();
    }

    /**
     * {@inheritDoc}
     */
    public function getRecurrenceInterval()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRecurrenceInterval', array());

        return parent::getRecurrenceInterval();
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentAccount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurrentAccount', array());

        return parent::getCurrentAccount();
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPaymentType', array());

        return parent::getPaymentType();
    }

    /**
     * {@inheritDoc}
     */
    public function getAccountingItem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAccountingItem', array());

        return parent::getAccountingItem();
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDocumentType', array());

        return parent::getDocumentType();
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
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
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
    public function setEmissionDate($emissionDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmissionDate', array($emissionDate));

        return parent::setEmissionDate($emissionDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setExpirationDate($expirationDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExpirationDate', array($expirationDate));

        return parent::setExpirationDate($expirationDate);
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
    public function setParcels($parcels)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParcels', array($parcels));

        return parent::setParcels($parcels);
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentParcel($currentParcel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurrentParcel', array($currentParcel));

        return parent::setCurrentParcel($currentParcel);
    }

    /**
     * {@inheritDoc}
     */
    public function setBarcode($barcode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBarcode', array($barcode));

        return parent::setBarcode($barcode);
    }

    /**
     * {@inheritDoc}
     */
    public function setAutoLaunch($autoLaunch)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAutoLaunch', array($autoLaunch));

        return parent::setAutoLaunch($autoLaunch);
    }

    /**
     * {@inheritDoc}
     */
    public function setFine($fine)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFine', array($fine));

        return parent::setFine($fine);
    }

    /**
     * {@inheritDoc}
     */
    public function setInterest($interest)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInterest', array($interest));

        return parent::setInterest($interest);
    }

    /**
     * {@inheritDoc}
     */
    public function setInterestInterval($interestInterval)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInterestInterval', array($interestInterval));

        return parent::setInterestInterval($interestInterval);
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
    public function setDatetime($datetime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatetime', array($datetime));

        return parent::setDatetime($datetime);
    }

    /**
     * {@inheritDoc}
     */
    public function setDone($done)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDone', array($done));

        return parent::setDone($done);
    }

    /**
     * {@inheritDoc}
     */
    public function setDoneDate($doneDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDoneDate', array($doneDate));

        return parent::setDoneDate($doneDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setDoneValue($doneValue)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDoneValue', array($doneValue));

        return parent::setDoneValue($doneValue);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsRecurrent($isRecurrent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsRecurrent', array($isRecurrent));

        return parent::setIsRecurrent($isRecurrent);
    }

    /**
     * {@inheritDoc}
     */
    public function setRecurrenceInterval($recurrenceInterval)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRecurrenceInterval', array($recurrenceInterval));

        return parent::setRecurrenceInterval($recurrenceInterval);
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentAccount(\DtlCurrentAccount\Entity\CurrentAccount $currentAccount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurrentAccount', array($currentAccount));

        return parent::setCurrentAccount($currentAccount);
    }

    /**
     * {@inheritDoc}
     */
    public function setPaymentType(\DtlPaymentType\Entity\PaymentType $paymentType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPaymentType', array($paymentType));

        return parent::setPaymentType($paymentType);
    }

    /**
     * {@inheritDoc}
     */
    public function setAccountingItem(\DtlAccountingItem\Entity\AccountingItem $accountingItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAccountingItem', array($accountingItem));

        return parent::setAccountingItem($accountingItem);
    }

    /**
     * {@inheritDoc}
     */
    public function setDocumentType(\DtlDocumentType\Entity\DocumentType $documentType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDocumentType', array($documentType));

        return parent::setDocumentType($documentType);
    }

}
