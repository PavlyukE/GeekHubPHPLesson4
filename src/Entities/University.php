<?php

namespace Entities;

class University
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $site;
    /**
     * Constructor.
     */
    public function __construct($id, $name, $city, $site)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->site = $site;
    }
    /**
     * Set id.
     *
     * @param int $id
     *
     * @return University
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set name.
     *
     * @param string $name
     *
     * @return University
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set city.
     *
     * @param string $city
     *
     * @return University
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set site.
     *
     * @param string $site
     *
     * @return University
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }
}
