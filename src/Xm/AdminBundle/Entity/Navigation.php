<?php

namespace Xm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Navigation
 *
 * @ORM\Table(name="navigation")
 * @ORM\Entity
 */
class Navigation
{
    /**
     * @var string
     *
     * @ORM\Column(name="flag", type="string", length=45, nullable=true)
     */
    private $flag;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", length=4, nullable=true)
     */
    private $weight;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", length=4, nullable=true)
     */
    private $level;
    /**
     * @var integer
     *
     * @ORM\Column(name="enable", type="integer", length=1, nullable=true)
     */
    private $enable;

    /**
     * Set level
     *
     * @param int $level
     *
     * @return Navigation
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
    /**
     * Set flag
     *
     * @param string $flag
     *
     * @return Navigation
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Navigation
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
     * Set weight
     *
     * @param int $weight
     *
     * @return Navigation
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set enable
     *
     * @param int $enalbe
     *
     * @return Navigation
     */
    public function setEnable($enalbe)
    {
        $this->enable = $enalbe;

        return $this;
    }

    /**
     * Get enable
     *
     * @return string
     */
    public function getEnable()
    {
        return $this->enable;
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
}
