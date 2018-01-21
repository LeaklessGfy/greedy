<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * Needs
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Needs
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ne laisse pas ce champ vide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Ton titre est trop court",
     *      maxMessage = "Ton titre est trop long",
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank(
     *      message = "Ne laisse pas ce champ vide."
     * )
     * @Assert\Type(
     *      type = "numeric",
     *      message = "Cette valeur n'est pas une quantité"
     * )
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="measure", type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ne laisse pas ce champ vide."
     * )
     * @Assert\Choice(
     *      choices = { "unit","kg","g","mg","L","cL","mL" }
     * )
     */
    private $measure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     * @Assert\NotBlank(
     *      message = "Ne laisse pas ce champ vide."
     * )
     * @AppAssert\EndDate
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="needs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Position", inversedBy="needs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     */
    protected $position;

    /**
     * @ORM\OneToMany(targetEntity="ChatRoom", mappedBy="need", cascade={"persist", "remove"})
     */
    protected $chatRoom;

    public function __construct(User $user) {
        $this->answer = new ArrayCollection();
        $this->owner = $user;
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
     * Set title
     *
     * @param string $title
     * @return Needs
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
     * Set description
     *
     * @param string $description
     * @return Needs
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
     * Set quantity
     *
     * @param integer $quantity
     * @return Needs
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set measure
     *
     * @param string $measure
     * @return Needs
     */
    public function setMeasure($measure)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return string 
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Needs
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
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     * @return Needs
     */
    public function setOwner(User $owner = null)
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
     * Set position
     *
     * @param \AppBundle\Entity\Position $position
     * @return Needs
     */
    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \AppBundle\Entity\Position 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Needs
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
     * Add chatRoom
     *
     * @param \AppBundle\Entity\ChatRoom $chatRoom
     * @return Needs
     */
    public function addChatRoom(ChatRoom $chatRoom)
    {
        $this->chatRoom[] = $chatRoom;

        return $this;
    }

    /**
     * Remove chatRoom
     *
     * @param \AppBundle\Entity\ChatRoom $chatRoom
     */
    public function removeChatRoom(ChatRoom $chatRoom)
    {
        $this->chatRoom->removeElement($chatRoom);
    }

    /**
     * Get chatRoom
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }
}
