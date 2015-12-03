<?php

namespace Ais\RuangBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\RuangBundle\Model\RuangInterface;
use Ais\RuangBundle\Form\RuangType;
use Ais\RuangBundle\Exception\InvalidFormException;

class RuangHandler implements RuangHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a Ruang.
     *
     * @param mixed $id
     *
     * @return RuangInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Ruangs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new Ruang.
     *
     * @param array $parameters
     *
     * @return RuangInterface
     */
    public function post(array $parameters)
    {
        $ruang = $this->createRuang();

        return $this->processForm($ruang, $parameters, 'POST');
    }

    /**
     * Edit a Ruang.
     *
     * @param RuangInterface $ruang
     * @param array         $parameters
     *
     * @return RuangInterface
     */
    public function put(RuangInterface $ruang, array $parameters)
    {
        return $this->processForm($ruang, $parameters, 'PUT');
    }

    /**
     * Partially update a Ruang.
     *
     * @param RuangInterface $ruang
     * @param array         $parameters
     *
     * @return RuangInterface
     */
    public function patch(RuangInterface $ruang, array $parameters)
    {
        return $this->processForm($ruang, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param RuangInterface $ruang
     * @param array         $parameters
     * @param String        $method
     *
     * @return RuangInterface
     *
     * @throws \Ais\RuangBundle\Exception\InvalidFormException
     */
    private function processForm(RuangInterface $ruang, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new RuangType(), $ruang, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $ruang = $form->getData();
            $this->om->persist($ruang);
            $this->om->flush($ruang);

            return $ruang;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createRuang()
    {
        return new $this->entityClass();
    }

}
