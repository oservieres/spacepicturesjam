<?php
namespace SPJ\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="SPJ\GameBundle\Repository\RatingRepository")
 * @ORM\Table(name="rating")
 */
class Rating
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
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Picture", inversedBy="comments")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $picture;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pictures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @return Rating
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
     * Set value
     *
     * @param integer $value
     * @return Rating
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set picture
     *
     * @param \SPJ\GameBundle\Entity\Picture $picture
     * @return Rating
     */
    public function setPicture(\SPJ\GameBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return \SPJ\GameBundle\Entity\Picture 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set user
     *
     * @param \SPJ\GameBundle\Entity\User $user
     * @return Rating
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