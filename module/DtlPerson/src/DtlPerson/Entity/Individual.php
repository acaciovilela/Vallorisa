<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlOccupation\Entity\Occupation;

/**
 * @ORM\Entity
 * @ORM\Table(name="individual")
 */
class Individual {

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
    protected $cpf;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $rg;
    
    /**
     * @ORM\Column(name="rg_date", type="string", nullable=true)
     * @var string
     */
    protected $rgDate;
    
    /**
     * @ORM\Column(name="rg_organ", type="string", nullable=true)
     * @var string
     */
    protected $rgOrgan;
    
    /**
     * @ORM\Column(name="rg_uf", type="string", nullable=true)
     * @var string
     */
    protected $rgUf;
    
    /**
     * @ORM\Column(name="birth_day", type="string", nullable=true)
     * @var string
     */
    protected $birthDay;

    /**
     * @ORM\Column(name="birth_month", type="string", nullable=true)
     * @var string
     */
    protected $birthMonth;

    /**
     * @ORM\Column(name="birth_year", type="string", nullable=true)
     * @var int
     */
    protected $birthYear;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var bool
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $father;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $mother;

    /**
     * @ORM\Column(name="birth_place", type="string", nullable=true)
     * @var string
     */
    protected $birthPlace;

    /**
     * @ORM\Column(name="birth_uf", type="string", nullable=true)
     * @var string
     */
    protected $birthUf;

    /**
     * @ORM\Column(name="nationality", type="string", nullable=true)
     * @var string
     */
    protected $nationality;

    /**
     * @ORM\Column(name="status", type="string", nullable=true)
     * @var string
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Professional", cascade={"all"})
     * @var \DtlPerson\Entity\Professional
     */
    protected $professional;

    /**
     * @ORM\ManyToOne(targetEntity="DtlOccupation\Entity\Occupation", cascade={"persist"})
     * @var Occupation
     */
    protected $occupation;

    public function __construct() {
        $this->professional = new Professional();
    }

    public function getId() {
        return $this->id;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getBirthDay() {
        return $this->birthDay;
    }

    public function getBirthMonth() {
        return $this->birthMonth;
    }

    public function getBirthYear() {
        return $this->birthYear;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getFather() {
        return $this->father;
    }

    public function getMother() {
        return $this->mother;
    }

    public function getBirthPlace() {
        return $this->birthPlace;
    }

    public function getBirthUf() {
        return $this->birthUf;
    }

    public function getNationality() {
        return $this->nationality;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getProfessional() {
        return $this->professional;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

    public function setRg($rg) {
        $this->rg = $rg;
        return $this;
    }

    public function setBirthDay($birthDay) {
        $this->birthDay = $birthDay;
        return $this;
    }

    public function setBirthMonth($birthMonth) {
        $this->birthMonth = $birthMonth;
        return $this;
    }

    public function setBirthYear($birthYear) {
        $this->birthYear = $birthYear;
        return $this;
    }

    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    public function setFather($father) {
        $this->father = $father;
        return $this;
    }

    public function setMother($mother) {
        $this->mother = $mother;
        return $this;
    }

    public function setBirthPlace($birthPlace) {
        $this->birthPlace = $birthPlace;
        return $this;
    }

    public function setBirthUf($birthUf) {
        $this->birthUf = $birthUf;
        return $this;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setProfessional($professional) {
        $this->professional = $professional;
        return $this;
    }

    public function getOccupation() {
        return $this->occupation;
    }

    public function setOccupation(Occupation $occupation) {
        $this->occupation = $occupation;
        return $this;
    }

    public function getRgDate() {
        return $this->rgDate;
    }

    public function getRgOrgan() {
        return $this->rgOrgan;
    }

    public function getRgUf() {
        return $this->rgUf;
    }

    public function setRgDate($rgDate) {
        $this->rgDate = $rgDate;
        return $this;
    }

    public function setRgOrgan($rgOrgan) {
        $this->rgOrgan = $rgOrgan;
        return $this;
    }

    public function setRgUf($rgUf) {
        $this->rgUf = $rgUf;
        return $this;
    }


}
