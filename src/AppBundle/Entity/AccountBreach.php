<?php
/**
 * Created by PhpStorm.
 * User: matthijs
 * Date: 16-11-17
 * Time: 0:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccountBreach
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class AccountBreach
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $breachedSite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $breachDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $breachedData;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $breachVerified;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getBreachedSite()
    {
        return $this->breachedSite;
    }

    /**
     * @param string $breachedSite
     */
    public function setBreachedSite($breachedSite)
    {
        $this->breachedSite = $breachedSite;
    }

    /**
     * @return \DateTime
     */
    public function getBreachDate()
    {
        return $this->breachDate;
    }

    /**
     * @param \DateTime $breachDate
     */
    public function setBreachDate($breachDate)
    {
        $this->breachDate = $breachDate;
    }

    /**
     * @return string
     */
    public function getBreachedData()
    {
        return $this->breachedData;
    }

    /**
     * @param string $breachedData
     */
    public function setBreachedData($breachedData)
    {
        $this->breachedData = $breachedData;
    }

    /**
     * @return bool
     */
    public function isBreachVerified()
    {
        return $this->breachVerified;
    }

    /**
     * @param bool $breachVerified
     */
    public function setBreachVerified($breachVerified)
    {
        $this->breachVerified = $breachVerified;
    }
}