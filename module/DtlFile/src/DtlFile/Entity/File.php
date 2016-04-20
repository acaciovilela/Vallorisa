<?php

namespace DtlFile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $size;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    public function __construct() {
        $this->size = 0;
        $this->isActive = true;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSize() {
        return $this->size;
    }

    function getType() {
        return $this->type;
    }

    function getUrl() {
        return $this->url;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setName($name) {
        $this->name = $name;
        return $this;
    }

    function setSize($size) {
        $this->size = $size;
        return $this;
    }

    function setType($type) {
        $this->type = $type;
        return $this;
    }

    function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }
}
