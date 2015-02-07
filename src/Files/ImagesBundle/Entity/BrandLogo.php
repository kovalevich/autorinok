<?php

namespace Files\ImagesBundle\Entity;

use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "catalog_logos")
 * @FileStore\Uploadable
 */
class BrandLogo
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Datetime
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="array")
     * @Assert\Image( maxSize="20M")
     * @FileStore\UploadableField(mapping="brand_logo")
     **/
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $photo
     * @return BrandLogo
     */
    public function setImage($photo)
    {
        $this->image = $photo;
        return $this;
    }
    /**
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \Datetime $date
     * @return BrandLogo
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BrandLogo
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
