<?php

namespace Netvlies\Bundle\NetvliesFormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Netvlies\Bundle\NetvliesFormBundle\Entity\Option;

class OptionFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $option = new Option();
        $option->setLabel('Mr.');
        $manager->persist($option);

        $this->addReference('option_contact_mr', $option);

        $option = new Option();
        $option->setLabel('Mrs.');
        $manager->persist($option);

        $this->addReference('option_contact_mrs', $option);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
