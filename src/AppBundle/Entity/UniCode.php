<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UniCode
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UniCode
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
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="available", type="integer")
     */
    private $available;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="uniCodes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @ORM\OneToOne(targetEntity="User", mappedBy="uniCode")
     **/
    private $utilisator;

    /**
     * Constructor
     */
    public function __construct(User $owner)
    {
        $this->available = 1;
        $this->owner = $owner;
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
     * Set code
     *
     * @param string $code
     * @return UniCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     * @return UniCode
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set available
     *
     * @param integer $available
     * @return UniCode
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return integer 
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set utilisator
     *
     * @param \AppBundle\Entity\User $utilisator
     * @return UniCode
     */
    public function setUtilisator(\AppBundle\Entity\User $utilisator = null)
    {
        $this->utilisator = $utilisator;

        return $this;
    }

    /**
     * Get utilisator
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUtilisator()
    {
        return $this->utilisator;
    }
}
