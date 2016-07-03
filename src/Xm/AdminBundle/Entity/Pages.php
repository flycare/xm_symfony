<?php

namespace Xm\AdminBundle\Entity;

/**
 * Pages
 */
class Pages
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $flag;

    /**
     * @var string
     */
    private $content;


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
     * Set flag
     *
     * @param string $flag
     *
     * @return Pages
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
     * Set content
     *
     * @param string $content
     *
     * @return Pages
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
}

