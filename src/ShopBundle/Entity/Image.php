<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ImageRepository")
 * @Vich\Uploadable
 */
class Image
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     */
    private $product;


    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true)
     */
    private $page;

    /**
     * @var text
     *
     * @ORM\Column(name="teasing", type="text", nullable=true)
     */
    private $teasing;

    /**
     * @var text
     *
     * @ORM\Column(name="redirectUrl", type="string", length=255, nullable=true)
     */
    private $redirectUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="imageSource", type="string", length=255)
     */
    public $imageSource;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageSource")
     * @var File
     *
     */
    private $imageSourceFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageSmall", type="string", length=255, nullable=true)
     */
    public $imageSmall;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageSmall")
     * @var File
     *
     */
    private $imageSmallFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageMedium", type="string", length=255, nullable=true)
     */
    public $imageMedium;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageMedium")
     * @var File
     *
     */
    private $imageMediumFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageBig", type="string", length=255, nullable=true)
     */
    public $imageBig;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageBig")
     * @var File
     *
     */
    private $imageBigFile;


    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=255)
     */
    private $legend;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * Many Sliders have Many Images.
     * @ORM\ManyToMany(targetEntity="Slider", mappedBy="images")
     * @ORM\JoinTable(name="sliders_images")
     */
    private $sliders;

    /**
     * Many Picks have Many Images.
     * @ORM\ManyToMany(targetEntity="Picks", mappedBy="images")
     * @ORM\JoinTable(name="pickss_images")
     */
    private $pickss;


    public function __construct() {
        $this->pickss = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sliders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getImageSource();
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
     * Set slider
     *
     * @param integer $slider
     *
     * @return Image
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;
        return $this;
    }

    /**
     * Get slider
     *
     * @return int
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return Image
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get product
     *
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set page
     *
     * @param integer $page
     *
     * @return Page
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
     * Set legend
     *
     * @param string $legend
     *
     * @return Image
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }

    /**
     * Get legend
     *
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set teasing
     *
     * @param string $teasing
     *
     * @return Image
     */
    public function setTeasing($teasing)
    {
        $this->teasing = $teasing;
        return $this;
    }

    /**
     * Get teasing
     *
     * @return string
     */
    public function getTeasing()
    {
        return $this->teasing;
    }

    /**
     * Set redirect URL
     *
     * @param string $redirectUrl
     *
     * @return RedirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * Get redirect URL
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set source image file
     *
     * @return imageSourceFile
     */
    public function setImageSourceFile(File $image = null)
    {
        $this->imageSourceFile = $image;
    }

    /**
     * Get source image file
     *
     * @return imageSourceFile
     */
    public function getImageSourceFile()
    {
        return $this->imageSourceFile;
    }

    /**
     * Set source image
     *
     */
    public function setImageSource($image)
    {
        $this->imageSource = $image;
    }

    /**
     * Get source image
     *
     * @return imageSource
     */
    public function getImageSource()
    {
        return $this->imageSource;
    }

    /**
     * Set small image file
     *
     * @return imageSmallFile
     */
    public function setImageSmallFile(File $image = null)
    {
        $this->imageSmallFile = $image;
    }

    /**
     * Get small image file
     *
     * @return imageSmallFile
     */
    public function getImageSmallFile()
    {
        return $this->imageSmallFile;
    }

    /**
     * Set small image
     *
     */
    public function setSmallImage($image)
    {
        $this->imageSmall = $image;
    }

    /**
     * Get small image
     *
     * @return imageSmall
     */
    public function getImageSmall()
    {
        return $this->imageSmall;
    }

    /**
     * Set medium image file
     *
     * @return imageMediumFile
     */
    public function setImageMediumFile(File $image = null)
    {
        $this->imageMediumFile = $image;
    }

    /**
     * Get medium image file
     *
     * @return imageMediumFile
     */
    public function getImageMediumFile()
    {
        return $this->imageMediumFile;
    }

    /**
     * Set medium image
     *
     */
    public function setMediumImage($image)
    {
        $this->imageMedium = $image;
    }

    /**
     * Get medium image
     *
     * @return imageMedium
     */
    public function getImageMedium()
    {
        return $this->imageMedium;
    }


    /**
     * Set big image file
     *
     * @return imageBigFile
     */
    public function setImageBigFile(File $image = null)
    {
        $this->imageBigFile = $image;
    }

    /**
     * Get big image file
     *
     * @return imageBigFile
     */
    public function getImageBigFile()
    {
        return $this->imageBigFile;
    }

    /**
     * Set big image
     *
     */
    public function setBigImage($image)
    {
        $this->imageBig = $image;
    }

    /**
     * Get big image
     *
     * @return imageBig
     */
    public function getBigSmall()
    {
        return $this->imageBig;
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
     * Get all picks
     *
     * @return ArrayCollection
     */
    public function getPickss()
    {
        return $this->pickss;
    }

    /**
     * Get all sliders
     *
     * @return ArrayCollection
     */
    public function getSliders()
    {
        return $this->sliders;
    }

    /**
     * Add a slider
     *
     * @param Slider $slider
     *
     * @return Image
     */
    public function addSlider(Slider $slider)
    {
        $this->sliders[] = $slider;
        return $this;
    }

    /**
     * Remove a slider
     *
     * @param Slider $slider
     *
     * @return Image
     */
    public function removeSlider(Slider $slider)
    {
        $this->sliders->removeElement($slider);
    }
}

