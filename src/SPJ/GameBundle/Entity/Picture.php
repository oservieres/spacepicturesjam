<?php
namespace SPJ\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="picture")
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $location;

    /**
     * @ORM\Column(type="string", length=160)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $focalLength;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $aperture;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $ISO;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $shutterSpeed;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $path;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $miniaturePath;

    /**
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="pictures")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     */
    protected $challenge;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pictures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Picture
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Picture
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
     * Set location
     *
     * @param string $location
     * @return Picture
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Picture
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
     * Set focalLength
     *
     * @param string $focalLength
     * @return Picture
     */
    public function setFocalLength($focalLength)
    {
        $this->focalLength = $focalLength;
    
        return $this;
    }

    /**
     * Get focalLength
     *
     * @return string 
     */
    public function getFocalLength()
    {
        return $this->focalLength;
    }

    /**
     * Set aperture
     *
     * @param string $aperture
     * @return Picture
     */
    public function setAperture($aperture)
    {
        $this->aperture = $aperture;
    
        return $this;
    }

    /**
     * Get aperture
     *
     * @return string 
     */
    public function getAperture()
    {
        return $this->aperture;
    }

    /**
     * Set ISO
     *
     * @param string $iSO
     * @return Picture
     */
    public function setISO($iSO)
    {
        $this->ISO = $iSO;
    
        return $this;
    }

    /**
     * Get ISO
     *
     * @return string 
     */
    public function getISO()
    {
        return $this->ISO;
    }

    /**
     * Set shutterSpeed
     *
     * @param string $shutterSpeed
     * @return Picture
     */
    public function setShutterSpeed($shutterSpeed)
    {
        $this->shutterSpeed = $shutterSpeed;
    
        return $this;
    }

    /**
     * Get shutterSpeed
     *
     * @return string 
     */
    public function getShutterSpeed()
    {
        return $this->shutterSpeed;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Picture
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set miniaturePath
     *
     * @param string $miniaturePath
     * @return Picture
     */
    public function setMiniaturePath($miniaturePath)
    {
        $this->miniaturePath = $miniaturePath;
    
        return $this;
    }

    /**
     * Get miniaturePath
     *
     * @return string 
     */
    public function getMiniaturePath()
    {
        return $this->miniaturePath;
    }

    /**
     * Set challenge
     *
     * @param \SPJ\GameBundle\Entity\Challenge $challenge
     * @return Picture
     */
    public function setChallenge(\SPJ\GameBundle\Entity\Challenge $challenge = null)
    {
        $this->challenge = $challenge;
    
        return $this;
    }

    /**
     * Get challenge
     *
     * @return \SPJ\GameBundle\Entity\Challenge 
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * Set user
     *
     * @param \SPJ\GameBundle\Entity\User $user
     * @return Picture
     */
    public function setUser(\SPJ\GameBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \SPJ\GameBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}