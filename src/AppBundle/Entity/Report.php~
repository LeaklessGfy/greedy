<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Report
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
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reportMade")
     * @ORM\JoinColumn(name="informer_id", referencedColumnName="id")
     */
    private $informer;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="report")
     * @ORM\JoinColumn(name="reportuser_id", referencedColumnName="id")
     */
    private $reportUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set action
     *
     * @param string $action
     * @return Report
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Report
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set informer
     *
     * @param string $informer
     * @return Report
     */
    public function setInformer($informer)
    {
        $this->informer = $informer;

        return $this;
    }

    /**
     * Get informer
     *
     * @return string 
     */
    public function getInformer()
    {
        return $this->informer;
    }

    /**
     * Set reportUser
     *
     * @param string $reportUser
     * @return Report
     */
    public function setReportUser($reportUser)
    {
        $this->reportUser = $reportUser;

        return $this;
    }

    /**
     * Get reportUser
     *
     * @return string 
     */
    public function getReportUser()
    {
        return $this->reportUser;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Report
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
}
