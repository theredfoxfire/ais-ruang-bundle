<?php

namespace Ais\RuangBundle\Tests\Handler;

use Ais\RuangBundle\Handler\RuangHandler;
use Ais\RuangBundle\Model\RuangInterface;
use Ais\RuangBundle\Entity\Ruang;

class RuangHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\RuangBundle\Tests\Handler\DummyRuang';

    /** @var RuangHandler */
    protected $ruangHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $ruang = $this->getRuang();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($ruang));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->ruangHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $ruangs = $this->getRuangs(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($ruangs));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->ruangHandler->all($limit, $offset);

        $this->assertEquals($ruangs, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ruang = $this->getRuang();
        $ruang->setTitle($title);
        $ruang->setBody($body);

        $form = $this->getMock('Ais\RuangBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ruang));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ruangObject = $this->ruangHandler->post($parameters);

        $this->assertEquals($ruangObject, $ruang);
    }

    /**
     * @expectedException Ais\RuangBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ruang = $this->getRuang();
        $ruang->setTitle($title);
        $ruang->setBody($body);

        $form = $this->getMock('Ais\RuangBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->ruangHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $ruang = $this->getRuang();
        $ruang->setTitle($title);
        $ruang->setBody($body);

        $form = $this->getMock('Ais\RuangBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ruang));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ruangObject = $this->ruangHandler->put($ruang, $parameters);

        $this->assertEquals($ruangObject, $ruang);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $ruang = $this->getRuang();
        $ruang->setTitle($title);
        $ruang->setBody($body);

        $form = $this->getMock('Ais\RuangBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($ruang));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->ruangHandler = $this->createRuangHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $ruangObject = $this->ruangHandler->patch($ruang, $parameters);

        $this->assertEquals($ruangObject, $ruang);
    }


    protected function createRuangHandler($objectManager, $ruangClass, $formFactory)
    {
        return new RuangHandler($objectManager, $ruangClass, $formFactory);
    }

    protected function getRuang()
    {
        $ruangClass = static::DOSEN_CLASS;

        return new $ruangClass();
    }

    protected function getRuangs($maxRuangs = 5)
    {
        $ruangs = array();
        for($i = 0; $i < $maxRuangs; $i++) {
            $ruangs[] = $this->getRuang();
        }

        return $ruangs;
    }
}

class DummyRuang extends Ruang
{
}
