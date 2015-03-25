<?php

namespace Auto\UsedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MostParsed
 *
 * @ORM\Table(name="used_most_parsed")
 * @ORM\Entity(repositoryClass="Auto\UsedBundle\Entity\MostParsedRepository")
 */
class MostParsed
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
     * @ORM\Column(name="site", type="string", length=255)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="parse_id", type="string", length=255)
     */
    private $parseId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_parsed", type="boolean")
     */
    private $isParsed;

    /**
     * @var string
     *
     * @ORM\Column(name="parse_key", length=32, unique=true)
     */
    private $parseKey;


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
     * Set site
     *
     * @param string $site
     * @return MostParsed
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set parseId
     *
     * @param string $parseId
     * @return MostParsed
     */
    public function setParseId($parseId)
    {
        $this->parseId = $parseId;

        return $this;
    }

    /**
     * Get parseId
     *
     * @return integer 
     */
    public function getParseId()
    {
        return $this->parseId;
    }

    /**
     * Set isParsed
     *
     * @param boolean $isParsed
     * @return MostParsed
     */
    public function setIsParsed($isParsed)
    {
        $this->isParsed = $isParsed;

        return $this;
    }

    /**
     * Get isParsed
     *
     * @return boolean 
     */
    public function getIsParsed()
    {
        return $this->isParsed;
    }

    /**
     * Set parseKey
     *
     * @param string $parseKey
     * @return MostParsed
     */
    public function setParseKey($parseKey)
    {
        $this->parseKey = $parseKey;

        return $this;
    }

    /**
     * Get parseKey
     *
     * @return string 
     */
    public function getParseKey()
    {
        return $this->parseKey;
    }
}
