<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table(name="text")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\TextRepository")
 */
class Text
{

    const FORMAT_STANDARD = 'standard';
    const FORMAT_FLASH = 'flash';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; 

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true)
     */
    private $page;

    /**
     * @var Format
     *
     * @ORM\Column(name="format", type="text", length=50)
     */
    private $format;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * Many Picks have Many Textes.
     * @ORM\ManyToMany(targetEntity="Picks", mappedBy="textes")
     * @ORM\JoinTable(name="pickss_textes")
     */
    private $pickss;


    public function __construct() {
        $this->pickss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Text
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return Text
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set page
     *
     * @param string $page
     *
     * @return Text
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Text
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    } 

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Page
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Add a picks
     *
     * @param Picks $picks
     *
     * @return Image
     */
    public function addPicks(Picks $picks)
    {   
        $this->pickss[] = $picks;

        return $this;
    }

    /**
     * Remove a picks
     *
     * @param Picks $picks
     *
     * @return Image
     */
    public function removePicks(Picks $picks)
    {   
        $this->pickss->removeElement($picks);
    }

    /**
     * Get all pickss
     *
     * @return ArrayCollection
     */
    public function getPickss()
    {
        return $this->pickss;
    }

}

