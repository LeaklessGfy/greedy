<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="eReputation", type="integer")
     */
    private $eReputation;

    /**
     * @ORM\OneToOne(targetEntity="UniCode", inversedBy="utilisator")
     * @ORM\JoinColumn(name="unicode_id", referencedColumnName="id")
     */
    private $uniCode;

    /**
     * @ORM\OneToMany(targetEntity="UniCode", mappedBy="owner")
     */
    protected $uniCodes;

    /**
     * @ORM\OneToMany(targetEntity="Needs", mappedBy="owner")
     */
    protected $needs;

    /**
     * @ORM\OneToMany(targetEntity="Messages", mappedBy="sender")
     */
    protected $msgSend;

    /**
     * @ORM\OneToMany(targetEntity="Messages", mappedBy="receiver")
     */
    protected $msgReceive;

    /**
     * @ORM\OneToMany(targetEntity="ChatRoom", mappedBy="seller")
     */
    protected $sellerChat;

    /**
     * @ORM\OneToMany(targetEntity="ChatRoom", mappedBy="buyer")
     */
    protected $buyerChat;

    /**
     * @var string
     *
     * @ORM\Column(name="parent", type="string", length=255, nullable=true)
     */
    private $parent;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Badges")
     * @ORM\JoinTable(name="users_badges",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="badge_id", referencedColumnName="id")}
     *      )
     **/
    private $badges;

    /**
     * @ORM\OneToMany(targetEntity="Report", mappedBy="informer")
     */
    protected $reportMade;

    /**
     * @ORM\OneToMany(targetEntity="Report", mappedBy="reportUser")
     */
    protected $report;

    /**
     * @ORM\ManyToOne(targetEntity="Cities")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="city_id")
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set e-reputation
     *
     * @param integer $eReputation
     * @return User
     */
    public function setEReputation($eReputation)
    {
        $this->eReputation = $eReputation;

        return $this;
    }

    /**
     * Get e-reputation
     *
     * @return integer 
     */
    public function getEReputation()
    {
        return $this->eReputation;
    }

    /**
     * Set uni-code
     *
     * @param string $uniCode
     * @return User
     */
    public function setUniCode($uniCode)
    {
        $this->uniCode = $uniCode;

        return $this;
    }

    /**
     * Get uni-code
     *
     * @return string 
     */
    public function getUniCode()
    {
        return $this->uniCode;
    }

    /**
     * Set parent
     *
     * @param string $parent
     * @return User
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        if($this->getUsername() == 'Admin') {
            return array('ROLE_ADMIN');
        }
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uniCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->badges = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add uniCodes
     *
     * @param \AppBundle\Entity\UniCode $uniCodes
     * @return User
     */
    public function addUniCode(\AppBundle\Entity\UniCode $uniCodes)
    {
        $this->uniCodes[] = $uniCodes;

        return $this;
    }

    /**
     * Remove uniCodes
     *
     * @param \AppBundle\Entity\UniCode $uniCodes
     */
    public function removeUniCode(\AppBundle\Entity\UniCode $uniCodes)
    {
        $this->uniCodes->removeElement($uniCodes);
    }

    /**
     * Get uniCodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUniCodes()
    {
        return $this->uniCodes;
    }

    /**
     * Add needs
     *
     * @param \AppBundle\Entity\Needs $needs
     * @return User
     */
    public function addNeed(\AppBundle\Entity\Needs $needs)
    {
        $this->needs[] = $needs;

        return $this;
    }

    /**
     * Remove needs
     *
     * @param \AppBundle\Entity\Needs $needs
     */
    public function removeNeed(\AppBundle\Entity\Needs $needs)
    {
        $this->needs->removeElement($needs);
    }

    /**
     * Get needs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNeeds()
    {
        return $this->needs;
    }

    /**
     * Add reportMade
     *
     * @param \AppBundle\Entity\Report $reportMade
     * @return User
     */
    public function addReportMade(\AppBundle\Entity\Report $reportMade)
    {
        $this->reportMade[] = $reportMade;

        return $this;
    }

    /**
     * Remove reportMade
     *
     * @param \AppBundle\Entity\Report $reportMade
     */
    public function removeReportMade(\AppBundle\Entity\Report $reportMade)
    {
        $this->reportMade->removeElement($reportMade);
    }

    /**
     * Get reportMade
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReportMade()
    {
        return $this->reportMade;
    }

    /**
     * Add report
     *
     * @param \AppBundle\Entity\Report $report
     * @return User
     */
    public function addReport(\AppBundle\Entity\Report $report)
    {
        $this->report[] = $report;

        return $this;
    }

    /**
     * Remove report
     *
     * @param \AppBundle\Entity\Report $report
     */
    public function removeReport(\AppBundle\Entity\Report $report)
    {
        $this->report->removeElement($report);
    }

    /**
     * Get report
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Add badges
     *
     * @param \AppBundle\Entity\Badges $badges
     * @return User
     */
    public function addBadge(\AppBundle\Entity\Badges $badges)
    {
        $this->badges[] = $badges;

        return $this;
    }

    /**
     * Remove badges
     *
     * @param \AppBundle\Entity\Badges $badges
     */
    public function removeBadge(\AppBundle\Entity\Badges $badges)
    {
        $this->badges->removeElement($badges);
    }

    /**
     * Get badges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * Add msgSend
     *
     * @param \AppBundle\Entity\ChatRoom $msgSend
     * @return User
     */
    public function addMsgSend(\AppBundle\Entity\ChatRoom $msgSend)
    {
        $this->msgSend[] = $msgSend;

        return $this;
    }

    /**
     * Remove msgSend
     *
     * @param \AppBundle\Entity\ChatRoom $msgSend
     */
    public function removeMsgSend(\AppBundle\Entity\ChatRoom $msgSend)
    {
        $this->msgSend->removeElement($msgSend);
    }

    /**
     * Get msgSend
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMsgSend()
    {
        return $this->msgSend;
    }

    /**
     * Add msgReceive
     *
     * @param \AppBundle\Entity\ChatRoom $msgReceive
     * @return User
     */
    public function addMsgReceive(\AppBundle\Entity\ChatRoom $msgReceive)
    {
        $this->msgReceive[] = $msgReceive;

        return $this;
    }

    /**
     * Remove msgReceive
     *
     * @param \AppBundle\Entity\ChatRoom $msgReceive
     */
    public function removeMsgReceive(\AppBundle\Entity\ChatRoom $msgReceive)
    {
        $this->msgReceive->removeElement($msgReceive);
    }

    /**
     * Get msgReceive
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMsgReceive()
    {
        return $this->msgReceive;
    }

    /**
     * Add sellerChat
     *
     * @param \AppBundle\Entity\ChatRoom $sellerChat
     * @return User
     */
    public function addSellerChat(\AppBundle\Entity\ChatRoom $sellerChat)
    {
        $this->sellerChat[] = $sellerChat;

        return $this;
    }

    /**
     * Remove sellerChat
     *
     * @param \AppBundle\Entity\ChatRoom $sellerChat
     */
    public function removeSellerChat(\AppBundle\Entity\ChatRoom $sellerChat)
    {
        $this->sellerChat->removeElement($sellerChat);
    }

    /**
     * Get sellerChat
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSellerChat()
    {
        return $this->sellerChat;
    }

    /**
     * Add buyerChat
     *
     * @param \AppBundle\Entity\ChatRoom $buyerChat
     * @return User
     */
    public function addBuyerChat(\AppBundle\Entity\ChatRoom $buyerChat)
    {
        $this->buyerChat[] = $buyerChat;

        return $this;
    }

    /**
     * Remove buyerChat
     *
     * @param \AppBundle\Entity\ChatRoom $buyerChat
     */
    public function removeBuyerChat(\AppBundle\Entity\ChatRoom $buyerChat)
    {
        $this->buyerChat->removeElement($buyerChat);
    }

    /**
     * Get buyerChat
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBuyerChat()
    {
        return $this->buyerChat;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\Cities $city
     * @return User
     */
    public function setCity(\AppBundle\Entity\Cities $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\Cities 
     */
    public function getCity()
    {
        return $this->city;
    }
}
