<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subcategories")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;
 
    /**
     * Many categories have many subcategories.
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $subcategories;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


    public function __construct()
    {
        $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set qName
     *
     * @param string $qName
     *
     * @return Category
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
     * @return Category
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
     * Set parent category
     *
     * @param string $parent
     *
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent category
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add a child category
     *
     * @param Category $category
     *
     * @return Category
     */
    public function addSubcategory(Category $subcategory)
    {
        $this->subcategories[] = $subcategory;
        if (!$subcategory->getSubcategories()->contains($this)) {
            $subcategory->addSubcategory($this);
        }
        return $this;
    }

    /**
     * Remove a child category
     *
     * @param Category $category
     *
     * @return Category
     */
    public function removeSubcategory(Category $subcategory)
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get all children categories
     *
     * @return ArrayCollection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
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
}

