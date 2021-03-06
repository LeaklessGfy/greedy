<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Position
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Position
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
     * @ORM\ManyToOne(targetEntity="Cities", inversedBy="positions")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="city_id")
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=7)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="Needs", mappedBy="position")
     */
    protected $needs;


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
     * Set city
     *
     * @param string $city
     * @return Position
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Position
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Position
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->needs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add needs
     *
     * @param \AppBundle\Entity\Needs $needs
     * @return Position
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
}
