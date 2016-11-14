<?php

namespace Entities;

class Department
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
     * @var int
     */
    protected $university_id;

    /**
     * Constructor.
     */
    public function __construct($id, $name, $university_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->university_id = $university_id;
    }
    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Department
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
     * @return Department
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
     * Set university_id.
     *
     * @param int $university_id
     *
     * @return Department
     */
    public function setUniversityId($university_id)
    {
        $this->university_id = $university_id;

        return $this;
    }
    /**
     * Get university_id.
     *
     * @return int
     */
    public function getUniversityId()
    {
        return $this->university_id;
    }
}
