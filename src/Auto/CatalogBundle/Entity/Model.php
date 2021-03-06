<?php

namespace Auto\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model
 *
 * @ORM\Table(name="catalog_models")
 * @ORM\Entity(repositoryClass="Auto\CatalogBundle\Entity\ModelRepository")
 */
class Model
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="models")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    protected $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Model", inversedBy="models")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="parent")
     */
    protected $models;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="synonyms", type="string", length=500)
     */
    private $synonyms;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="popular", type="boolean")
     */
    private $popular;

    /**
     * @ORM\OneToMany(targetEntity="Generation", mappedBy="model")
     */
    protected $generations;

    /**
     * @var integer
     *
     * @ORM\Column(name="filling", type="integer", options={"default":0})
     */
    protected $filling;

    public function __construct()
    {
        $this->generations = new ArrayCollection();
        $this->models = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Model
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
     * Set synonyms
     *
     * @param string $synonyms
     * @return Model
     */
    public function setSynonyms($synonyms)
    {
        $this->synonyms = implode(',',$synonyms);

        return $this;
    }

    /**
     * Get synonyms
     *
     * @return string 
     */
    public function getSynonyms()
    {
        return $this->synonyms;
    }

    /**
     * Set popular
     *
     * @param boolean $popular
     * @return Model
     */
    public function setPopular($popular)
    {
        $this->popular = $popular;

        return $this;
    }

    /**
     * Get popular
     *
     * @return boolean 
     */
    public function getPopular()
    {
        return $this->popular;
    }

    /**
     * Set brand
     *
     * @param \Auto\CatalogBundle\Entity\Brand $brand
     * @return Model
     */
    public function setBrand(\Auto\CatalogBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Auto\CatalogBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add generations
     *
     * @param \Auto\CatalogBundle\Entity\Generation $generations
     * @return Model
     */
    public function addGeneration(\Auto\CatalogBundle\Entity\Generation $generations)
    {
        $this->generations[] = $generations;

        return $this;
    }

    /**
     * Remove generations
     *
     * @param \Auto\CatalogBundle\Entity\Generation $generations
     */
    public function removeGeneration(\Auto\CatalogBundle\Entity\Generation $generations)
    {
        $this->generations->removeElement($generations);
    }

    /**
     * Get generations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenerations()
    {
        return $this->generations;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Model
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set parent
     *
     * @param \Auto\CatalogBundle\Entity\Model $parent
     * @return Model
     */
    public function setParent(\Auto\CatalogBundle\Entity\Model $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Auto\CatalogBundle\Entity\Model 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add models
     *
     * @param \Auto\CatalogBundle\Entity\Model $models
     * @return Model
     */
    public function addModel(\Auto\CatalogBundle\Entity\Model $models)
    {
        $this->models[] = $models;

        return $this;
    }

    /**
     * Remove models
     *
     * @param \Auto\CatalogBundle\Entity\Model $models
     */
    public function removeModel(\Auto\CatalogBundle\Entity\Model $models)
    {
        $this->models->removeElement($models);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Model
     */
    public function setText($text)
    {
        $this->text = urldecode($text);
        $this->setFilling(strlen(strip_tags($this->text)) / 2000 * 100);
        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }


    /**
     * Set filling
     *
     * @param integer $filling
     * @return Model
     */
    public function setFilling($filling)
    {
        $this->filling = $filling <= 100 ? $filling : 100;

        return $this;
    }

    /**
     * Get filling
     *
     * @return integer 
     */
    public function getFilling()
    {
        return $this->filling;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Model
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
