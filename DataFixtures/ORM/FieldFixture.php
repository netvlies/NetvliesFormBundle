<?php

namespace Netvlies\Bundle\FormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Netvlies\Bundle\FormBundle\Entity\Field;

class FieldFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Contact form fields
        $field = new Field();
        $field->setLabel('Naam');
        $field->setType($manager->merge($this->getReference('field_type_text')));
        $manager->persist($field);

        $this->addReference('field_contact_name', $field);

        $field = new Field();
        $field->setLabel('E-mailadres');
        $field->setType($manager->merge($this->getReference('field_type_email')));
        $manager->persist($field);

        $this->addReference('field_contact_email', $field);

        $field = new Field();
        $field->setLabel('Bericht');
        $field->setType($manager->merge($this->getReference('field_type_textarea')));
        $manager->persist($field);

        $this->addReference('field_contact_message', $field);

        // Application form fields
        $field = new Field();
        $field->setLabel('Naam');
        $field->setType($manager->merge($this->getReference('field_type_text')));
        $manager->persist($field);

        $this->addReference('field_application_name', $field);

        $field = new Field();
        $field->setLabel('Functie');
        $field->setType($manager->merge($this->getReference('field_type_email')));
        $manager->persist($field);

        $this->addReference('field_application_function', $field);

        $field = new Field();
        $field->setLabel('Motivatie');
        $field->setType($manager->merge($this->getReference('field_type_textarea')));
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
