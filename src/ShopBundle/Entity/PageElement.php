<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageElement
 *
 * @ORM\Table(name="page_element")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\PageElementRepository")
 */
class PageElement
{

    const FORMAT_TEXT = 'text';
    const FORMAT_SLIDER = 'slider';
    const FORMAT_FORM = 'form';
    const FORMAT_IMAGE = 'image';
    const FORMAT_MAP = 'map';
    const FORMAT_VIDEO = 'video';
    const FORMAT_PICKS = 'picks';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false)
     */
    private $page;

    /**
     * @var integer
     *
     * @ORM\Column(name="element", type="integer")
     */
    public $element;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string")
     */
    private $format;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


    public function __toString()
    { 
        return (string) ($this->getFormat() . ' - ' . $this->getId());
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
     * Set page
     *
     * @param integer $page
     *
     * @return PageElement
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }


    /**
     * Set element
     *
     * @param integer $element
     *
     * @return PageElement
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return int
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return PageElement
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
     * Set position
     *
     * @param integer $position
     *
     * @return PageElement
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return PageElement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
}

