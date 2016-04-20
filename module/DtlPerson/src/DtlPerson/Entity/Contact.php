<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $cell;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $fax;

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getCell() {
        return $this->cell;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setCell($cell) {
        $this->cell = $cell;
        return $this;
    }

    public function setFax($fax) {
        $this->fax = $fax;
        return $this;
    }
}
