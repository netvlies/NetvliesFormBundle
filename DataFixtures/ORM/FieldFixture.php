<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Netvlies\Bundle\NetvliesFormBundle\Entity\Field;

class FieldFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Contact form fields
        $field = new Field();
        $field->setLabel('Salutation');
        $field->setType('select');
        $field->setSelectType('radio');
        $field->setRequired(true);
        $field->addOption($manager->merge($this->getReference('option_contact_mr')));
        $field->addOption($manager->merge($this->getReference('option_contact_mrs')));
        $field->setDefault('Mr.');
        $manager->persist($field);

        $this->addReference('field_contact_salutation', $field);

        $field = new Field();
        $field->setLabel('Name');
        $field->setType('text');
        $field->setRequired(true);
        $manager->persist($field);

        $this->addReference('field_contact_name', $field);

        $field = new Field();
        $field->setLabel('Email address');
        $field->setType('email');
        $field->setRequired(true);
        $manager->persist($field);

        $this->addReference('field_contact_email', $field);

        $field = new Field();
        $field->setLabel('Message');
        $field->setType('textarea');
        $field->setRequired(true);
        $manager->persist($field);

        $this->addReference('field_contact_message', $field);

        // Application form fields
        $field = new Field();
        $field->setLabel('Name');
        $field->setType('text');
        $manager->persist($field);

        $this->addReference('field_application_name', $field);

        $field = new Field();
        $field->setLabel('Function');
        $field->setType('text');
        $manager->persist($field);

        $this->addReference('field_application_function', $field);

        $field = new Field();
        $field->setLabel('Motivation');
        $field->setType('textarea');
        $manager->persist($field);

        $this->addReference('field_application_motivation', $field);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
