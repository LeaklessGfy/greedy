<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Messages
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
     * @ORM\ManyToOne(targetEntity="ChatRoom", inversedBy="messages")
     * @ORM\JoinColumn(name="chatroom_id", referencedColumnName="id")
     */
    private $chatRoom;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="msgSend")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="msgReceive")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Constructor
     */
    public function __construct(ChatRoom $chatRoom, User $sender, User $receiver)
    {
        $this->chatRoom = $chatRoom;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->date = new \DateTime();
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
     * Set chatRoom
     *
     * @param integer $chatRoom
     * @return Messages
     */
    public function setChatRoom($chatRoom)
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    /**
     * Get chatRoom
     *
     * @return integer 
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }

    /**
     * Set sender
     *
     * @param integer $sender
     * @return Messages
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return integer 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Messages
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
     * Set date
     *
     * @param \DateTime $date
     * @return Messages
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set receiver
     *
     * @param \AppBundle\Entity\User $receiver
     * @return Messages
     */
    public function setReceiver(User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \AppBundle\Entity\User 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
