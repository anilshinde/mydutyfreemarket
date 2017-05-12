<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="items")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ItemsRepository")
 */
class Items
{

    const SORT_STANDARD = 'standard';
    const SORT_BEST = 'best';
    const SORT_RANDOM = 'random';

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
     * @ORM\Column(name="teasing", type="text")
     */
    private $teasing;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=true)
     */
    private $page;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @var Sort
     *
     * @ORM\Column(name="sort", type="text", length=50)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit", type="integer")
     */
    private $limit;


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
     * @return Items
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
     * Set teasing
     *
     * @param string $teasing
     *
     * @return Items
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
     * Set page
     *
     * @param string $page
     *
     * @return Items
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
     * Set category
     *
     * @param string $category
     *
     * @return Items
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set sort
     *
     * @param string $sort
     *
     * @return Items
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set limit
     *
     * @param integer $limit
     *
     * @return Items
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get limit
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

}

