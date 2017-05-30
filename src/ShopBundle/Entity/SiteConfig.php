<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * SiteConfig
 *
 * @ORM\Table(name="site_config")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\SiteConfigRepository")
 * @Vich\Uploadable
 */
class SiteConfig
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="faviconSource", type="string", length=255)
     */
    public $faviconSource;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="faviconSource")
     * @var File
     *
     */
    private $faviconSourceFile;

    /**
     * @var string
     *
     * @ORM\Column(name="logoSource", type="string", length=255)
     */
    public $logoSource;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="logoSource")
     * @var File
     *
     */
    private $logoSourceFile; 

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

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
     * @return SiteConfig
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
     * Set source favicon file
     *
     * @return SiteConfig
     */
    public function setFaviconSourceFile(File $favicon = null)
    {
        $this->faviconSourceFile = $favicon;
    }

    /**
     * Get source favicon file
     *
     * @return File
     */
    public function getFaviconSourceFile()
    {
        return $this->faviconSourceFile;
    }

    /**
     * Set source favicon
     *
     */
    public function setFaviconSource($favicon)
    {
        $this->faviconSource = $favicon;
    }

    /**
     * Get source favicon
     *
     * @return File
     */
    public function getFaviconSource()
    {
        return $this->faviconSource;
    }

    /**
     * Set source logo file
     *
     * @return SiteConfig
     */
    public function setLogoSourceFile(File $logo = null)
    {
        $this->logoSourceFile = $logo;
    }

    /**
     * Get source logo file
     *
     * @return File
     */
    public function getLogoSourceFile()
    {
        return $this->logoSourceFile;
    }

    /**
     * Set source logo
     *
     */
    public function setLogoSource($logo)
    {
        $this->logoSource = $logo;
    }

    /**
     * Get source logo
     *
     * @return File
     */
    public function getLogoSource()
    {
        return $this->logoSource;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SiteConfig
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
     * Set address
     *
     * @param string $address
     *
     * @return SiteConfig
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return SiteConfig
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return SiteConfig
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return SiteConfig
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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

