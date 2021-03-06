<?php

namespace Auto\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Generation
 *
 * @ORM\Table(name="catalog_generations")
 * @ORM\Entity(repositoryClass="Auto\CatalogBundle\Entity\GenerationRepository")
 */
class Generation
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
     * @ORM\ManyToOne(targetEntity="Model", inversedBy="generations")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="first_year", type="integer")
     */
    private $firstYear;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_year", type="integer")
     */
    private $lastYear;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="filling", type="integer", options={"default":0})
     */
    protected $filling;


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
     * @return Generation
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
     * Set firstYear
     *
     * @param integer $firstYear
     * @return Generation
     */
    public function setFirstYear($firstYear)
    {
        $this->firstYear = $firstYear;

        return $this;
    }

    /**
     * Get firstYear
     *
     * @return integer 
     */
    public function getFirstYear()
    {
        return $this->firstYear;
    }

    /**
     * Set lastYear
     *
     * @param integer $lastYear
     * @return Generation
     */
    public function setLastYear($lastYear)
    {
        $this->lastYear = $lastYear;

        return $this;
    }

    /**
     * Get lastYear
     *
     * @return integer 
     */
    public function getLastYear()
    {
        return $this->lastYear;
    }

    /**
     * Set model
     *
     * @param \Auto\CatalogBundle\Entity\Model $model
     * @return Generation
     */
    public function setModel(\Auto\CatalogBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \Auto\CatalogBundle\Entity\Model 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Generation
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
     * @return Generation
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
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Generation
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
