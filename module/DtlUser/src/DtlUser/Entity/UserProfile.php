<?php

namespace DtlUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Address;
use DtlPerson\Entity\Contact;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_profile")
 */
class UserProfile {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @var string
     */
    protected $lastName;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $about;
    
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean", options={"default":true})
     */
    protected $news;
    
    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Address", cascade={"all"})
     * @var Address
     */
    protected $address;
    
    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Contact", cascade={"all"})
     * @var Contact
     */
    protected $contact;
    
    public function __construct() {
        $this->address = new Address();
        $this->contact = new Contact();
        $this->news = true;
    }

    public function getId() {
        return $this->id;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getAbout() {
        return $this->about;
    }

    public function getNews() {
        return $this->news;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function setAbout($about) {
        $this->about = $about;
        return $this;
    }

    public function setNews($news) {
        $this->news = $news;
        return $this;
    }
    
    public function getAddress() {
        return $this->address;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setContact(Contact $contact) {
        $this->contact = $contact;
        return $this;
    }
}
