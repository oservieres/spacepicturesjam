<?php
namespace SPJ\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SPJ\GameBundle\Repository\ChallengeRepository")
 * @ORM\Table(name="challenge")
 */
class Challenge
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
   i  */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endVotingDate;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $subject;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $status = "queued";

     /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="challenge")
     */
    protected $pictures;

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
     * Set subject
     *
     * @param string $subject
     * @return Challenge
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Challenge
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Challenge
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Challenge
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add pictures
     *
     * @param \SPJ\GameBundle\Entity\Picture $pictures
     * @return Challenge
     */
    public function addPicture(\SPJ\GameBundle\Entity\Picture $pictures)
    {
        $this->pictures[] = $pictures;
    
        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \SPJ\GameBundle\Entity\Picture $pictures
     */
    public function removePicture(\SPJ\GameBundle\Entity\Picture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set endVotingDate
     *
     * @param \DateTime $endVotingDate
     * @return Challenge
     */
    public function setEndVotingDate($endVotingDate)
    {
        $this->endVotingDate = $endVotingDate;

        return $this;
    }

    /**
     * Get endVotingDate
     *
     * @return \DateTime
     */
    public function getEndVotingDate()
    {
        return $this->endVotingDate;
    }
}