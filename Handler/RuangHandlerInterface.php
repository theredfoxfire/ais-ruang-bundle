<?php

namespace Ais\RuangBundle\Handler;

use Ais\RuangBundle\Model\RuangInterface;

interface RuangHandlerInterface
{
    /**
     * Get a Ruang given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return RuangInterface
     */
    public function get($id);

    /**
     * Get a list of Ruangs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Ruang, creates a new Ruang.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return RuangInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Ruang.
     *
     * @api
     *
     * @param RuangInterface   $ruang
     * @param array           $parameters
     *
     * @return RuangInterface
     */
    public function put(RuangInterface $ruang, array $parameters);

    /**
     * Partially update a Ruang.
     *
     * @api
     *
     * @param RuangInterface   $ruang
     * @param array           $parameters
     *
     * @return RuangInterface
     */
    public function patch(RuangInterface $ruang, array $parameters);
}
