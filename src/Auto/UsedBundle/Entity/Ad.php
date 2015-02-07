<?php

namespace Auto\UsedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ad
 *
 * @ORM\Table(name="used_ads")
 * @ORM\Entity(repositoryClass="Auto\UsedBundle\Entity\AdRepository")
 */
class Ad
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
     * @ORM\ManyToOne(targetEntity="Auto\CatalogBundle\Entity\Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    protected $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Auto\CatalogBundle\Entity\Model")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    /**
     * @ORM\ManyToOne(targetEntity="Auto\CatalogBundle\Entity\Generation")
     * @ORM\JoinColumn(name="generation_id", referencedColumnName="id")
     */
    protected $generation;

    /**
     * @ORM\ManyToOne(targetEntity="Profile\UserBundle\Entity\User", inversedBy="used_ads")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="modification", type="string", length=255)
     */
    private $modification;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="price_view", type="integer")
     */
    private $priceView;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upped", type="datetime")
     */
    private $upped;

    /**
     * @var integer
     *
     * @ORM\Column(name="millage", type="integer")
     */
    private $millage;

    /**
     * @var integer
     *
     * @ORM\Column(name="engine", type="integer")
     */
    private $engine;

    /**
     * @var integer
     *
     * @ORM\Column(name="transmission", type="integer")
     */
    private $transmission;

    /**
     * @var integer
     *
     * @ORM\Column(name="volume", type="integer")
     */
    private $volume;

    /**
     * @var integer
     *
     * @ORM\Column(name="road", type="integer")
     */
    private $road;

    /**
     * @var integer
     *
     * @ORM\Column(name="color", type="integer")
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="body", type="integer")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="persone", type="string", length=255)
     */
    private $persone;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var integer
     *
     * @ORM\Column(name="cylinders", type="integer")
     */
    private $cylinders;

    /**
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=255)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=255)
     */
    private $phone2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_1", type="boolean")
     */
    private $option1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_2", type="boolean")
     */
    private $option2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_3", type="boolean")
     */
    private $option3;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_4", type="boolean")
     */
    private $option4;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_5", type="boolean")
     */
    private $option5;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_6", type="boolean")
     */
    private $option6;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_7", type="boolean")
     */
    private $option7;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_8", type="boolean")
     */
    private $option8;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_9", type="boolean")
     */
    private $option9;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_10", type="boolean")
     */
    private $option10;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_11", type="boolean")
     */
    private $option11;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_12", type="boolean")
     */
    private $option12;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_13", type="boolean")
     */
    private $option13;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_14", type="boolean")
     */
    private $option14;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_15", type="boolean")
     */
    private $option15;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_16", type="boolean")
     */
    private $option16;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_17", type="boolean")
     */
    private $option17;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_18", type="boolean")
     */
    private $option18;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_19", type="boolean")
     */
    private $option19;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_20", type="boolean")
     */
    private $option20;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="parse_site", type="string", length=255)
     */
    private $parseSite;

    /**
     * @var integer
     *
     * @ORM\Column(name="parse_id", type="integer")
     */
    private $parseId;

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="text")
     */
    private $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="condit", type="integer")
     */
    private $condit;

    /**
     * @var integer
     *
     * @ORM\Column(name="cleared", type="integer")
     */
    private $cleared;


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
     * Set title
     *
     * @param string $title
     * @return Ad
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

    /**
     * Set modification
     *
     * @param string $modification
     * @return Ad
     */
    public function setModification($modification)
    {
        $this->modification = $modification;

        return $this;
    }

    /**
     * Get modification
     *
     * @return string 
     */
    public function getModification()
    {
        return $this->modification;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Ad
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceView
     *
     * @param integer $priceView
     * @return Ad
     */
    public function setPriceView($priceView)
    {
        $this->priceView = $priceView;

        return $this;
    }

    /**
     * Get priceView
     *
     * @return integer 
     */
    public function getPriceView()
    {
        return $this->priceView;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Ad
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ad
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
     * Set created
     *
     * @param \DateTime $created
     * @return Ad
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set upped
     *
     * @param \DateTime $upped
     * @return Ad
     */
    public function setUpped($upped)
    {
        $this->upped = $upped;

        return $this;
    }

    /**
     * Get upped
     *
     * @return \DateTime 
     */
    public function getUpped()
    {
        return $this->upped;
    }

    /**
     * Set millage
     *
     * @param integer $millage
     * @return Ad
     */
    public function setMillage($millage)
    {
        $this->millage = $millage;

        return $this;
    }

    /**
     * Get millage
     *
     * @return integer 
     */
    public function getMillage()
    {
        return $this->millage;
    }

    /**
     * Set engine
     *
     * @param integer $engine
     * @return Ad
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return integer 
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set transmission
     *
     * @param integer $transmission
     * @return Ad
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return integer 
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Ad
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set road
     *
     * @param integer $road
     * @return Ad
     */
    public function setRoad($road)
    {
        $this->road = $road;

        return $this;
    }

    /**
     * Get road
     *
     * @return integer 
     */
    public function getRoad()
    {
        return $this->road;
    }

    /**
     * Set color
     *
     * @param integer $color
     * @return Ad
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return integer 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set body
     *
     * @param integer $body
     * @return Ad
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return integer 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set persone
     *
     * @param string $persone
     * @return Ad
     */
    public function setPersone($persone)
    {
        $this->persone = $persone;

        return $this;
    }

    /**
     * Get persone
     *
     * @return string 
     */
    public function getPersone()
    {
        return $this->persone;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Ad
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Ad
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set cylinders
     *
     * @param integer $cylinders
     * @return Ad
     */
    public function setCylinders($cylinders)
    {
        $this->cylinders = $cylinders;

        return $this;
    }

    /**
     * Get cylinders
     *
     * @return integer 
     */
    public function getCylinders()
    {
        return $this->cylinders;
    }

    /**
     * Set vin
     *
     * @param string $vin
     * @return Ad
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string 
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Ad
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
     * Set phone2
     *
     * @param string $phone2
     * @return Ad
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string 
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Set option1
     *
     * @param boolean $option1
     * @return Ad
     */
    public function setOption1($option1)
    {
        $this->option1 = $option1;

        return $this;
    }

    /**
     * Get option1
     *
     * @return boolean 
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * Set option2
     *
     * @param boolean $option2
     * @return Ad
     */
    public function setOption2($option2)
    {
        $this->option2 = $option2;

        return $this;
    }

    /**
     * Get option2
     *
     * @return boolean 
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Ad
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set parseSite
     *
     * @param string $parseSite
     * @return Ad
     */
    public function setParseSite($parseSite)
    {
        $this->parseSite = $parseSite;

        return $this;
    }

    /**
     * Get parseSite
     *
     * @return string 
     */
    public function getParseSite()
    {
        return $this->parseSite;
    }

    /**
     * Set parseId
     *
     * @param integer $parseId
     * @return Ad
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
     * Set images
     *
     * @param string $images
     * @return Ad
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set condit
     *
     * @param integer $condit
     * @return Ad
     */
    public function setCondit($condit)
    {
        $this->condit = $condit;

        return $this;
    }

    /**
     * Get condit
     *
     * @return integer 
     */
    public function getCondit()
    {
        return $this->condit;
    }

    /**
     * Set cleared
     *
     * @param integer $cleared
     * @return Ad
     */
    public function setCleared($cleared)
    {
        $this->cleared = $cleared;

        return $this;
    }

    /**
     * Get cleared
     *
     * @return integer 
     */
    public function getCleared()
    {
        return $this->cleared;
    }

    /**
     * Set option3
     *
     * @param boolean $option3
     * @return Ad
     */
    public function setOption3($option3)
    {
        $this->option3 = $option3;

        return $this;
    }

    /**
     * Get option3
     *
     * @return boolean 
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * Set option4
     *
     * @param boolean $option4
     * @return Ad
     */
    public function setOption4($option4)
    {
        $this->option4 = $option4;

        return $this;
    }

    /**
     * Get option4
     *
     * @return boolean 
     */
    public function getOption4()
    {
        return $this->option4;
    }

    /**
     * Set option5
     *
     * @param boolean $option5
     * @return Ad
     */
    public function setOption5($option5)
    {
        $this->option5 = $option5;

        return $this;
    }

    /**
     * Get option5
     *
     * @return boolean 
     */
    public function getOption5()
    {
        return $this->option5;
    }

    /**
     * Set option6
     *
     * @param boolean $option6
     * @return Ad
     */
    public function setOption6($option6)
    {
        $this->option6 = $option6;

        return $this;
    }

    /**
     * Get option6
     *
     * @return boolean 
     */
    public function getOption6()
    {
        return $this->option6;
    }

    /**
     * Set option7
     *
     * @param boolean $option7
     * @return Ad
     */
    public function setOption7($option7)
    {
        $this->option7 = $option7;

        return $this;
    }

    /**
     * Get option7
     *
     * @return boolean 
     */
    public function getOption7()
    {
        return $this->option7;
    }

    /**
     * Set option8
     *
     * @param boolean $option8
     * @return Ad
     */
    public function setOption8($option8)
    {
        $this->option8 = $option8;

        return $this;
    }

    /**
     * Get option8
     *
     * @return boolean 
     */
    public function getOption8()
    {
        return $this->option8;
    }

    /**
     * Set option9
     *
     * @param boolean $option9
     * @return Ad
     */
    public function setOption9($option9)
    {
        $this->option9 = $option9;

        return $this;
    }

    /**
     * Get option9
     *
     * @return boolean 
     */
    public function getOption9()
    {
        return $this->option9;
    }

    /**
     * Set option10
     *
     * @param boolean $option10
     * @return Ad
     */
    public function setOption10($option10)
    {
        $this->option10 = $option10;

        return $this;
    }

    /**
     * Get option10
     *
     * @return boolean 
     */
    public function getOption10()
    {
        return $this->option10;
    }

    /**
     * Set option11
     *
     * @param boolean $option11
     * @return Ad
     */
    public function setOption11($option11)
    {
        $this->option11 = $option11;

        return $this;
    }

    /**
     * Get option11
     *
     * @return boolean 
     */
    public function getOption11()
    {
        return $this->option11;
    }

    /**
     * Set option12
     *
     * @param boolean $option12
     * @return Ad
     */
    public function setOption12($option12)
    {
        $this->option12 = $option12;

        return $this;
    }

    /**
     * Get option12
     *
     * @return boolean 
     */
    public function getOption12()
    {
        return $this->option12;
    }

    /**
     * Set option13
     *
     * @param boolean $option13
     * @return Ad
     */
    public function setOption13($option13)
    {
        $this->option13 = $option13;

        return $this;
    }

    /**
     * Get option13
     *
     * @return boolean 
     */
    public function getOption13()
    {
        return $this->option13;
    }

    /**
     * Set option14
     *
     * @param boolean $option14
     * @return Ad
     */
    public function setOption14($option14)
    {
        $this->option14 = $option14;

        return $this;
    }

    /**
     * Get option14
     *
     * @return boolean 
     */
    public function getOption14()
    {
        return $this->option14;
    }

    /**
     * Set option15
     *
     * @param boolean $option15
     * @return Ad
     */
    public function setOption15($option15)
    {
        $this->option15 = $option15;

        return $this;
    }

    /**
     * Get option15
     *
     * @return boolean 
     */
    public function getOption15()
    {
        return $this->option15;
    }

    /**
     * Set option16
     *
     * @param boolean $option16
     * @return Ad
     */
    public function setOption16($option16)
    {
        $this->option16 = $option16;

        return $this;
    }

    /**
     * Get option16
     *
     * @return boolean 
     */
    public function getOption16()
    {
        return $this->option16;
    }

    /**
     * Set option17
     *
     * @param boolean $option17
     * @return Ad
     */
    public function setOption17($option17)
    {
        $this->option17 = $option17;

        return $this;
    }

    /**
     * Get option17
     *
     * @return boolean 
     */
    public function getOption17()
    {
        return $this->option17;
    }

    /**
     * Set option18
     *
     * @param boolean $option18
     * @return Ad
     */
    public function setOption18($option18)
    {
        $this->option18 = $option18;

        return $this;
    }

    /**
     * Get option18
     *
     * @return boolean 
     */
    public function getOption18()
    {
        return $this->option18;
    }

    /**
     * Set option19
     *
     * @param boolean $option19
     * @return Ad
     */
    public function setOption19($option19)
    {
        $this->option19 = $option19;

        return $this;
    }

    /**
     * Get option19
     *
     * @return boolean 
     */
    public function getOption19()
    {
        return $this->option19;
    }

    /**
     * Set option20
     *
     * @param boolean $option20
     * @return Ad
     */
    public function setOption20($option20)
    {
        $this->option20 = $option20;

        return $this;
    }

    /**
     * Get option20
     *
     * @return boolean 
     */
    public function getOption20()
    {
        return $this->option20;
    }

    /**
     * Set brand
     *
     * @param \Auto\CatalogBundle\Entity\Brand $brand
     * @return Ad
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
     * Set model
     *
     * @param \Auto\CatalogBundle\Entity\Model $model
     * @return Ad
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
     * Set generation
     *
     * @param \Auto\CatalogBundle\Entity\Generation $generation
     * @return Ad
     */
    public function setGeneration(\Auto\CatalogBundle\Entity\Generation $generation = null)
    {
        $this->generation = $generation;

        return $this;
    }

    /**
     * Get generation
     *
     * @return \Auto\CatalogBundle\Entity\Generation 
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * Set user
     *
     * @param \Profile\UserBundle\Entity\User $user
     * @return Ad
     */
    public function setUser(\Profile\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Profile\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
