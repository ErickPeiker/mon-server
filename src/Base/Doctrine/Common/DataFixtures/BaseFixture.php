<?php

namespace App\Base\Doctrine\Common\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseFixture extends Fixture implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getFaker($locale = 'pt_BR')
    {
        return Factory::create($locale);
    }

    public function getReference($name, $manager = null)
    {
        if (!$this->referenceRepository->hasReference($name)) {
            throw new \OutOfBoundsException("Reference to: ({$name}) does not exist");
        }

        if (!$manager) {
            $manager = $this->referenceRepository->getManager();
        }

        $reference = $this->referenceRepository->getReferences()[$name];
        $meta = $manager->getClassMetadata(get_class($reference));
        $identities = $this->referenceRepository->getIdentities();

        if (!$manager->contains($reference) && isset($identities[$name])) {
            $reference = $manager->getReference(
                $meta->name,
                $identities[$name]
            );
        }

        return $reference;
    }
}
