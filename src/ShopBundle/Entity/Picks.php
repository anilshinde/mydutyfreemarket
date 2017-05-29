<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picks
 *
 * @ORM\Table(name="picks")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\PicksRepository")
 */
class Picks
{

    const PRODUCTS_MANUAL = 'products_manual';
    const PRODUCTS_BEST_SALES = 'products_best_sales';
    const PRODUCTS_LAST_SALES = 'products_last_sales';
    const PAGES_MANUAL = 'pages_manual';
    const IMAGES_MANUAL = 'images_manual';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true)
     */
    private $page;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", length=50) 
     */
    private $type;

   /**
     * @var period
     *
     * @ORM\Column(name="period", type="integer")
     */
    private $period;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * Many Picks have Many Images.
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="pickss")
     * @ORM\JoinTable(name="pickss_images")
     */
    private $images;

    /**
     * Many Picks have Many Textes.
     * @ORM\ManyToMany(targetEntity="Text", inversedBy="pickss")
     * @ORM\JoinTable(name="pickss_textes")
     */
    private $textes;

    /**
     * Many Picks have Many Products.
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="pickss")
     * @ORM\JoinTable(name="pickss_products")
     */
    private $products;

    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->textes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set page
     *
     * @param integer $page
     *
     * @return Picks
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
     * Set name
     *
     * @param string $name
     *
     * @return Picks
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
     * Set type
     *
     * @param string $type
     *
     * @return Picks
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set period
     *
     * @param integer $period
     *
     * @return Picks
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
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
     * Add an image
     *
     * @param Image $image
     *
     * @return Picks
     */
    public function addImage(Image $image)
    {   
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove an image
     *
     * @param Image $image
     *
     * @return Picks
     */
    public function removeImage(Image $image)
    {   
        $this->images->removeElement($image);
    }

    /**
     * Get all images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add a text
     *
     * @param Text $text
     *
     * @return Picks
     */
    public function addText(Text $text)
    {
        $this->textes[] = $text;

        return $this;
    }

    /**
     * Remove a text
     *
     * @param Text $text
     *
     * @return Picks
     */
    public function removeText(Text $text)
    {
        $this->textes->removeElement($text);
    }

    /**
     * Get all textes
     *
     * @return ArrayCollection
     */
    public function getTextes()
    {
        return $this->textes;
    }

    /**
     * Add a product
     *
     * @param Product $product
     *
     * @return Picks
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
        return $this;
    }

    /**
     * Remove a product
     *
     * @param Product $product
     *
     * @return Picks
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get all products
     *
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

}

