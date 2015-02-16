<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Region
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RegionRepository")
 */
class Region
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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="regions")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="region")
     */
    protected $regions;

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

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * Set slug
     *
     * @param string $slug
     * @return Region
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Region
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
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     * @return Region
     */
    public function setRegion(\AppBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add regions
     *
     * @param \AppBundle\Entity\Region $regions
     * @return Region
     */
    public function addRegion(\AppBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;

        return $this;
    }

    /**
     * Remove regions
     *
     * @param \AppBundle\Entity\Region $regions
     */
    public function removeRegion(\AppBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Region
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
     * @return Region
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
}
