<?php

namespace Auto\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Brand
 *
 * @ORM\Table(name="catalog_brands")
 * @ORM\Entity(repositoryClass="Auto\CatalogBundle\Entity\BrandRepository")
 */
class Brand
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * @var boolean
     *
     * @ORM\Column(name="popular", type="boolean")
     */
    private $popular;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity="Model", mappedBy="brand")
     */
    protected $models;

    /**
     * @ORM\ManyToOne(targetEntity="Files\ImagesBundle\Entity\BrandLogo")
     * @ORM\JoinColumn(name="logo_id", referencedColumnName="id", nullable=true)
     */
    protected $logo;

    /**
     * @var integer
     *
     * @ORM\Column(name="filling", type="integer", options={"default":0})
     */
    protected $filling;

    public function __construct()
    {
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
     * @return Brand
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
     * Set nameCanonical
     *
     * @param string $nameCanonical
     * @return Brand
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string 
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set synonyms
     *
     * @param string $synonyms
     * @return Brand
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
     * @return Brand
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
     * Add models
     *
     * @param \Auto\CatalogBundle\Entity\Model $models
     * @return Brand
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
     * Set alias
     *
     * @param string $alias
     * @return Brand
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
     * Set text
     *
     * @param string $text
     * @return Brand
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
     * Set logo
     *
     * @param \Files\ImagesBundle\Entity\BrandLogo $logo
     * @return Brand
     */
    public function setLogo(\Files\ImagesBundle\Entity\BrandLogo $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \Files\ImagesBundle\Entity\BrandLogo 
     */
    public function getLogo()
    {
        return $this->logo;
    }


    /**
     * Set filling
     *
     * @param integer $filling
     * @return Brand
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
        return $this->filling ? $this->filling : 0;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
