<?php

namespace Auto\UsedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\JoinColumn(name="generation_id", referencedColumnName="id", nullable=true)
     */
    protected $generation;

    /**
     * @ORM\ManyToOne(targetEntity="Profile\UserBundle\Entity\User", inversedBy="used_ads")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
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
     * @ORM\Column(name="modification", type="string", length=255, nullable=true)
     */
    private $modification;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;

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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="upped", type="datetime")
     */
    private $upped;

    /**
     * @var integer
     *
     * @ORM\Column(name="millage", type="integer", nullable=true)
     */
    private $millage;

    /**
     * @var integer
     *
     * @ORM\Column(name="engine", type="integer", nullable=true)
     */
    private $engine;

    /**
     * @var integer
     *
     * @ORM\Column(name="transmission", type="integer", nullable=true)
     */
    private $transmission;

    /**
     * @var integer
     *
     * @ORM\Column(name="volume", type="integer", nullable=true)
     */
    private $volume;

    /**
     * @var integer
     *
     * @ORM\Column(name="road", type="integer", nullable=true)
     */
    private $road;

    /**
     * @var integer
     *
     * @ORM\Column(name="color", type="integer", nullable=true)
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="body", type="integer", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="seller", type="string", length=255, nullable=true)
     */
    private $seller;

    /**
     * @var integer
     *
     * @ORM\Column(name="cylinders", type="integer", nullable=true)
     */
    private $cylinders;

    /**
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=255, nullable=true)
     */
    private $vin;

    /**
     * @var array
     *
     * @ORM\Column(name="phones", type="array")
     */
    private $phones;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_1", type="boolean", nullable=true, options={"default"=0})
     */
    private $option1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_2", type="boolean", nullable=true, options={"default"=0})
     */
    private $option2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_3", type="boolean", nullable=true, options={"default"=0})
     */
    private $option3;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_4", type="boolean", nullable=true, options={"default"=0})
     */
    private $option4;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_5", type="boolean", nullable=true, options={"default"=0})
     */
    private $option5;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_6", type="boolean", nullable=true, options={"default"=0})
     */
    private $option6;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_7", type="boolean", nullable=true, options={"default"=0})
     */
    private $option7;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_8", type="boolean", nullable=true, options={"default"=0})
     */
    private $option8;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_9", type="boolean", nullable=true, options={"default"=0})
     */
    private $option9;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_10", type="boolean", nullable=true, options={"default"=0})
     */
    private $option10;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_11", type="boolean", nullable=true, options={"default"=0})
     */
    private $option11;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_12", type="boolean", nullable=true, options={"default"=0})
     */
    private $option12;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_13", type="boolean", nullable=true, options={"default"=0})
     */
    private $option13;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_14", type="boolean", nullable=true, options={"default"=0})
     */
    private $option14;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_15", type="boolean", nullable=true, options={"default"=0})
     */
    private $option15;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_16", type="boolean", nullable=true, options={"default"=0})
     */
    private $option16;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_17", type="boolean", nullable=true, options={"default"=0})
     */
    private $option17;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_18", type="boolean", nullable=true, options={"default"=0})
     */
    private $option18;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_19", type="boolean", nullable=true, options={"default"=0})
     */
    private $option19;

    /**
     * @var boolean
     *
     * @ORM\Column(name="option_20", type="boolean", nullable=true, options={"default"=0})
     */
    private $option20;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true, options={"default"=0})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="parse_site", type="string", length=255, nullable=true)
     */
    private $parseSite;

    /**
     * @var integer
     *
     * @ORM\Column(name="parse_id", type="integer", nullable=true)
     */
    private $parseId;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="array", nullable=true)
     */
    private $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="car_condition", type="integer", nullable=true)
     */
    private $condition;

    /**
     * @var integer
     *
     * @ORM\Column(name="cleared", type="integer", nullable=true)
     */
    private $cleared;

    /**
     * @ORM\ManyToOne(targetEntity="LocationBundle\Entity\Country")
     * @ORM\JoinColumn(name="location_country_id", referencedColumnName="id", nullable=true)
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="LocationBundle\Entity\Region")
     * @ORM\JoinColumn(name="location_region_id", referencedColumnName="id", nullable=true)
     */
    protected $region;

    /**
     * @ORM\ManyToOne(targetEntity="LocationBundle\Entity\City")
     * @ORM\JoinColumn(name="location_city_id", referencedColumnName="id", nullable=true)
     */
    protected $city;


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
     * @param integer $course
     * @param string $currency
     * @return Ad
     */
    public function setPrice($price, $currency = '$', $course = 14800)
    {
        if($currency == '$')
            $this->price = $price;
        else {
            $this->price = $price / $course; # курс доллара
        }
        $this->setPriceView($price);

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
        $synonyms = array(
            1 =>    'газ',
            2 =>    'енз',
            3 =>    'изел',
            4 =>    'ибр',
            5 =>    'лек',
            6 =>    'рбодиз'
        );
        foreach($synonyms as $i => $synonym)
        {
            if(strstr($engine, $synonym)) $this->engine = $i;
        }

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
        $synonyms = array(
            1 =>    'еха', # mechanic
            2 =>    'вто', # automatic
            3 =>    'ари'
        );
        foreach($synonyms as $i => $synonym)
        {
            if(strstr($transmission, $synonym)) $this->transmission = $i;
        }

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
        if($volume < 500) $volume *= 1000;
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
        $synonyms = array(
            1 =>    'адн',
            2 =>    'еред',
            3 =>    'олн'
        );
        foreach($synonyms as $i => $synonym)
        {
            if(strstr($road, $synonym)) $this->road = $i;
        }

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
        $synonyms = array(
            1 =>    'еда',
            2 =>    'нивер',
            3 =>    'бэк',
            4 =>    'минив',
            5 =>    'упе',
            6 =>    'внед',
            7 =>    'крос',
            8 =>    'кабр',
            9 =>    'пик',
            10=>    'лим',
            11 =>   'автобу'
        );
        foreach($synonyms as $i => $synonym)
        {
            if(strstr($body, $synonym)) $this->body = $i;
        }

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
     * Set seller
     *
     * @param string $seller
     * @return Ad
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return string 
     */
    public function getSeller()
    {
        return $this->seller;
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
     * Set phones
     *
     * @param array $phones
     * @return Ad
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * Get phones
     *
     * @return array 
     */
    public function getPhones()
    {
        return $this->phones;
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
     * @param array $images
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
     * @return array 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set condition
     *
     * @param integer $condition
     * @return Ad
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition
     *
     * @return integer 
     */
    public function getCondition()
    {
        return $this->condition;
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

    /**
     * Set country
     *
     * @param \LocationBundle\Entity\Country $country
     * @return Ad
     */
    public function setCountry(\LocationBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \LocationBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param \LocationBundle\Entity\Region $region
     * @return Ad
     */
    public function setRegion(\LocationBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \LocationBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param \LocationBundle\Entity\City $city
     * @return Ad
     */
    public function setCity(\LocationBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \LocationBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * Set currency
     *
     * @param string $currency
     * @return Ad
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
