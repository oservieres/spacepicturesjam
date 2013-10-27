<?php
namespace SPJ\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="SPJ\GameBundle\Repository\PictureRepository")
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
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $location;

    /**
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $focalLength;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $aperture;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $ISO;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
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
     * @ORM\Column(type="string", length=100)
     */
    protected $blurredMiniaturePath;

    /**
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="pictures")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $challenge;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pictures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

     /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="picture")
     */
    protected $comments;

     /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="picture")
     */
    protected $ratings;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ratingsCount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ratingsAverage = 0;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
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

    /**
     * Set blurredMiniaturePath
     *
     * @param string $blurredMiniaturePath
     * @return Picture
     */
    public function setBlurredMiniaturePath($blurredMiniaturePath)
    {
        $this->blurredMiniaturePath = $blurredMiniaturePath;

        return $this;
    }

    /**
     * Get blurredMiniaturePath
     *
     * @return string
     */
    public function getBlurredMiniaturePath()
    {
        return $this->blurredMiniaturePath;
    }

    public function setExifProperties($exif)
    {
        if (array_key_exists('ShutterSpeedValue', $exif)) {
            $this->shutterSpeed = $exif['ShutterSpeedValue'];
        }

        if (array_key_exists('ApertureFNumber', $exif['COMPUTED'])) {
            $this->aperture = $exif['COMPUTED']['ApertureFNumber'];
        }

        if (@array_key_exists('ISOSpeedRatings', $exif)) {
            $this->ISO = $exif['ISOSpeedRatings'];
        }
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add comments
     *
     * @param \SPJ\GameBundle\Entity\Comment $comments
     * @return Picture
     */
    public function addComment(\SPJ\GameBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \SPJ\GameBundle\Entity\Comment $comments
     */
    public function removeComment(\SPJ\GameBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add ratings
     *
     * @param \SPJ\GameBundle\Entity\Rating $ratings
     * @return Picture
     */
    public function addRating(\SPJ\GameBundle\Entity\Rating $ratings)
    {
        $this->ratings[] = $ratings;
    
        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \SPJ\GameBundle\Entity\Rating $ratings
     */
    public function removeRating(\SPJ\GameBundle\Entity\Rating $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Set ratingsCount
     *
     * @param integer $ratingsCount
     * @return Picture
     */
    public function setRatingsCount($ratingsCount)
    {
        $this->ratingsCount = $ratingsCount;
    
        return $this;
    }

    /**
     * Get ratingsCount
     *
     * @return integer 
     */
    public function getRatingsCount()
    {
        return $this->ratingsCount;
    }

    /**
     * Set ratingsAverage
     *
     * @param integer $ratingsAverage
     * @return Picture
     */
    public function setRatingsAverage($ratingsAverage)
    {
        $this->ratingsAverage = $ratingsAverage;
    
        return $this;
    }

    /**
     * Get ratingsAverage
     *
     * @return integer 
     */
    public function getRatingsAverage()
    {
        return $this->ratingsAverage;
    }
}