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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
