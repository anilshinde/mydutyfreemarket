<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ProductRepository")
 */
class Product
{
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
     * @ORM\Column(name="qName", type="string", length=50, unique=true)
     */
    private $qName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", type="string", length=100, nullable=true)
     */
    private $promo;

    /**
     * @var float
     *
     * @ORM\Column(name="promo_rate", type="float", nullable=true)
     */
    private $promoRate;

    /**
     * @var float
     *
     * @ORM\Column(name="discounted_price", type="float", nullable=true)
     */
    private $discountedPrice;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * Product have many subcategories.
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="product")
     */
    private $images;


    /**
     * @var text
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var text
     *
     * @ORM\Column(name="documentation", type="text")
     */
    private $documentation;

    /**
     * @var string
     *
     * @ORM\Column(name="formats", type="string", length=200)
     */
    private $formats;

    /**
     * @var int
     *
     * @ORM\Column(name="current_stock", type="integer", nullable=true)
     */
    private $currentStock;

    /**
     * @var int
     *
     * @ORM\Column(name="current_sales", type="integer", nullable=true)
     */
    private $currentSales;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * Many Picks have Many Products.
     * @ORM\ManyToMany(targetEntity="Picks", mappedBy="products")
     * @ORM\JoinTable(name="pickss_products")
     */
    private $pickss;

    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pickss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getQName();
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
     * Set qName
     *
     * @param string $qName
     *
     * @return Product
     */
    public function setQName($qName)
    {
        $this->qName = $qName;

        return $this;
    }

    /**
     * Get qName
     *
     * @return string
     */
    public function getQName()
    {
        return $this->qName;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set category
     *
     * @param integer $category
     *
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
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
     * Add an image
     *
     * @param Image $image
     *
     * @return Product
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
     * @return Product
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set promo
     *
     * @param string $promo
     *
     * @return Product
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set promoRate
     *
     * @param float $promoRate
     *
     * @return Product
     */
    public function setPromoRate($promoRate)
    {
        $this->promoRate = $promoRate;

        return $this;
    }

    /**
     * Get promoRate
     *
     * @return float
     */
    public function getPromoRate()
    {
        return $this->promoRate;
    }

    /**
     * Set discountedPrice
     *
     * @param float $discountedPrice
     *
     * @return Product
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    /**
     * Get discountedPrice
     *
     * @return float
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Product
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set documentation
     *
     * @param string $documentation
     *
     * @return Product
     */
    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;

        return $this;
    }

    /**
     * Get documentation
     *
     * @return string
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * Set formats
     *
     * @param string $formats
     *
     * @return Product
     */
    public function setFormats($formats)
    {
        $this->formats = $formats;

        return $this;
    }

    /**
     * Get formats
     *
     * @return string
     */
    public function getFormats()
    {
        return $this->formats;
    }

    /**
     * Set currentStock
     *
     * @param integer $currentStock
     *
     * @return Product
     */
    public function setCurrentStock($currentStock)
    {
        $this->currentStock = $currentStock;

        return $this;
    }

    /**
     * Get currentStock
     *
     * @return int
     */
    public function getCurrentStock()
    {
        return $this->currentStock;
    }

    /**
     * Get currentSales
     *
     * @return int
     */
    public function getCurrentSales()
    {
        return $this->currentSales;
    }

   /**
     * Set currentSales
     *
     * @param integer $currentSales
     *
     * @return Product
     */
    public function setCurrentSales($currentSales)
    {
        $this->currentSales = $currentSales;

        return $this;
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

    /**
     * Add a picks
     *
     * @param Picks $picks
     *
     * @return Product
     */
    public function addPicks(Picks $picks)
    {
        $this->picks[] = $picks;
        return $this;
    }

    /**
     * Remove a picks
     *
     * @param Picks $picks
     *
     * @return Product
     */
    public function removePicks(Picks $picks)
    {
        $this->pickss->removeElement($picks);
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
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
