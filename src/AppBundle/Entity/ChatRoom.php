<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChatRoom
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChatRoomRepository")
 */
class ChatRoom
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
     * @ORM\ManyToOne(targetEntity="Needs", inversedBy="chatRoom")
     * @ORM\JoinColumn(name="need_id", referencedColumnName="id")
     */
    private $need;

    /**
     * @ORM\OneToMany(targetEntity="Messages", mappedBy="chatRoom")
     */
    protected $messages;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sellerChat")
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="id")
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="buyerChat")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id")
     */
    private $buyer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification", type="datetime")
     */
    private $lastModification;

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
     * Set need
     *
     * @param \AppBundle\Entity\Needs $need
     * @return ChatRoom
     */
    public function setNeed(\AppBundle\Entity\Needs $need = null)
    {
        $this->need = $need;

        return $this;
    }

    /**
     * Get need
     *
     * @return \AppBundle\Entity\Needs 
     */
    public function getNeed()
    {
        return $this->need;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add messages
     *
     * @param \AppBundle\Entity\Messages $messages
     * @return ChatRoom
     */
    public function addMessage(\AppBundle\Entity\Messages $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \AppBundle\Entity\Messages $messages
     */
    public function removeMessage(\AppBundle\Entity\Messages $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set seller
     *
     * @param \AppBundle\Entity\User $seller
     * @return ChatRoom
     */
    public function setSeller(\AppBundle\Entity\User $seller = null)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return \AppBundle\Entity\User 
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set buyer
     *
     * @param \AppBundle\Entity\User $buyer
     * @return ChatRoom
     */
    public function setBuyer(\AppBundle\Entity\User $buyer = null)
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * Get buyer
     *
     * @return \AppBundle\Entity\User 
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set lastModification
     *
     * @param \DateTime $lastModification
     * @return ChatRoom
     */
    public function setLastModification($lastModification)
    {
        $this->lastModification = $lastModification;

        return $this;
    }

    /**
     * Get lastModification
     *
     * @return \DateTime 
     */
    public function getLastModification()
    {
        return $this->lastModification;
    }
}
