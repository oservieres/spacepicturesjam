<?php
namespace SPJ\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="SPJ\GameBundle\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 */
class Comment
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
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="comments")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $challenge;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="challenges")
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
     * @return Comment
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
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set challenge
     *
     * @param \SPJ\GameBundle\Entity\Challenge $challenge
     * @return Comment
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
     * @return Comment
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

    public function getArrayData()
    {
        return array(
            'content' => $this->getContent(),
            'date_created' => $this->getDateCreated()->format("c"),
            'username' => $this->getUser()->getUsername()
        );
    }
}
