<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="legal")
 */
class Legal {

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
    protected $cnpj;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $subscription;

    /**
     * @ORM\Column(name="representative_name", type="string", nullable=true)
     * @var string
     */
    protected $representativeName;

    /**
     * @ORM\Column(name="representative_phone", type="string", nullable=true)
     * @var string
     */
    protected $representativePhone;

    /**
     * @ORM\Column(name="representative_rg", type="string", nullable=true)
     * @var string
     */
    protected $representativeRg;

    public function getId() {
        return $this->id;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getSubscription() {
        return $this->subscription;
    }

    public function getRepresentativeName() {
        return $this->representativeName;
    }

    public function getRepresentativePhone() {
        return $this->representativePhone;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function setSubscription($subscription) {
        $this->subscription = $subscription;
        return $this;
    }

    public function setRepresentativeName($representativeName) {
        $this->representativeName = $representativeName;
        return $this;
    }

    public function setRepresentativePhone($representativePhone) {
        $this->representativePhone = $representativePhone;
        return $this;
    }

    public function getRepresentativeRg() {
        return $this->representativeRg;
    }

    public function setRepresentativeRg($representativeRg) {
        $this->representativeRg = $representativeRg;
        return $this;
    }

}
