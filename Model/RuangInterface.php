<?php

namespace Ais\RuangBundle\Model;

Interface RuangInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set gedungId
     *
     * @param integer $gedungId
     *
     * @return Ruang
     */
    public function setGedungId($gedungId);

    /**
     * Get gedungId
     *
     * @return integer
     */
    public function getGedungId();

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Ruang
     */
    public function setNama($nama);

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Ruang
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Ruang
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
