<?php

namespace Ais\RuangBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\RuangBundle\Model\RuangInterface;

/**
 * Ruang
 */
class Ruang implements RuangInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $gedung_id;

    /**
     * @var string
     */
    private $nama;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var boolean
     */
    private $is_delete;


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
     * Set gedungId
     *
     * @param integer $gedungId
     *
     * @return Ruang
     */
    public function setGedungId($gedungId)
    {
        $this->gedung_id = $gedungId;

        return $this;
    }

    /**
     * Get gedungId
     *
     * @return integer
     */
    public function getGedungId()
    {
        return $this->gedung_id;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Ruang
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Ruang
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Ruang
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}

