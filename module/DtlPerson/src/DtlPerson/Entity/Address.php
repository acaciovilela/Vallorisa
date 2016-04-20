<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlLocation\Entity\City;
use DtlLocation\Entity\State;
use DtlLocation\Entity\Country;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var integer
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $complement;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $quarter;

    /**
     * @ORM\Column(name="postal_code", type="string", nullable=true)
     * @var string
     */
    protected $postalCode;

    /**
     * @ORM\Column(name="city_name", type="string", nullable=true)
     * @var string
     */
    protected $cityName;

    /**
     * @ORM\Column(name="state_name", type="string", nullable=true)
     * @var string
     */
    protected $stateName;

    /**
     * @ORM\Column(name="country_name", type="string", nullable=true)
     * @var string
     */
    protected $countryName;

    /**
     * @ORM\ManyToOne(targetEntity="DtlLocation\Entity\City", cascade={"persist"})
     * @var City
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="DtlLocation\Entity\State", cascade={"persist"})
     * @var State
     */
    protected $state;

    /**
     * @ORM\ManyToOne(targetEntity="DtlLocation\Entity\Country", cascade={"persist"})
     * @var Country
     */
    protected $country;
    
    public function __construct() {
        $this->number = 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getComplement() {
        return $this->complement;
    }

    public function getQuarter() {
        return $this->quarter;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function getCityName() {
        return $this->cityName;
    }

    public function getStateName() {
        return $this->stateName;
    }

    public function getCountryName() {
        return $this->countryName;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setNumber($number) {
        $this->number = (int) $number;
        return $this;
    }

    public function setComplement($complement) {
        $this->complement = $complement;
        return $this;
    }

    public function setQuarter($quarter) {
        $this->quarter = $quarter;
        return $this;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setCityName($cityName) {
        $this->cityName = $cityName;
        return $this;
    }

    public function setStateName($stateName) {
        $this->stateName = $stateName;
        return $this;
    }

    public function setCountryName($countryName) {
        $this->countryName = $countryName;
        return $this;
    }

    public function setCity(City $city) {
        $this->city = $city;
        return $this;
    }

    public function setState(State $state) {
        $this->state = $state;
        return $this;
    }

    public function setCountry(Country $country) {
        $this->country = $country;
        return $this;
    }

}
