<?php

namespace App\Base\Test\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker\Factory;

abstract class BaseRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->manager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->manager->close();
        $this->manager = null; // avoid memory leaks
    }

    protected function getFaker($locale = 'pt_BR')
    {
        return Factory::create($locale);
    }

    abstract public function getMockObject(array $except = []);

    public function getMockArray(array $except = [])
    {
        return $this->getMockObject($except)->toArray();
    }

    public function getFlushedMockObject(array $except = [])
    {
        if (!$this->manager) {
            $this->setUp();
        }

        $object = $this->getMockObject($except);

        $this->manager->persist($object);
        $this->manager->flush();

        return $object;
    }

    public function getFlushedMockArray(array $except = [])
    {
        return $this->getFlushedMockObject($except)->toArray();
    }

    public function testFindAll($object = null)
    {
        $object = $object ?? $this->getFlushedMockObject();

        $findAll = $this->manager->getRepository(get_class($object))->findAll()->getResult();

        $this->assertGreaterThan(0, count($findAll));
        $this->assertInstanceOf(get_class($object), $findAll[0]);
    }

    public function testFindBy()
    {
        $object = $object ?? $this->getFlushedMockObject();

        $findBy = $this->manager->getRepository(get_class($object))->findBy(['id' => $object->getId()])->getResult();

        $this->assertEquals($object->getId(), $findBy[0]->getId());
        $this->assertInstanceOf(get_class($object), $findBy[0]);
    }

    public function testFindOneBy()
    {
        $object = $this->getFlushedMockObject();

        $findOneBy = $this->manager->getRepository(get_class($object))->findOneBy(['id' => $object->getId()]);

        $this->assertEquals($object->getId(), $findOneBy->getId());
        $this->assertInstanceOf(get_class($object), $findOneBy);
    }
}
