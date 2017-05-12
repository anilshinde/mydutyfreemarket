<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\SliderRepository")
 */
class Slider
{

    const FORMAT_YELLOW = 'yellow';
    const FORMAT_BLUE = 'blue';

    const SIZE_MEDIUM = 'medium';
    const SIZE_BIG = 'big';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; 

    /**
     * @var array
     *
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true)
     */
    private $page;

    /**
     * @var integer
     *
     * @ORM\Column(name="delay", type="integer")
     */
    private $delay;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6)
     *
     */
    private $color; 

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=50)
     */
    private $size;


    public function __toString()
    {
        return $this->getName();
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
     * @return Slider
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
     * Set page
     *
     * @param string $page
     *
     * @return Slider
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
     * Set images
     *
     */
    public function setImage($images)
    {
        $this->images[] = $images;
    }

    /**
     * Get images
     *
     * return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     *
     * @return Slider
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Get delay
     *
     * @return integer
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Slider
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Slider
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

}

