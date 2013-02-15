<?php

namespace Netvlies\Bundle\FormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Netvlies\Bundle\FormBundle\Entity\FieldType;

class FieldTypeFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fieldType = new FieldType();
        $fieldType->setTag('text');
        $fieldType->setLabel('Tekstregel');
        $manager->persist($fieldType);

        $this->addReference('field_type_text', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('textarea');
        $fieldType->setLabel('Tekstblok');
        $manager->persist($fieldType);

        $this->addReference('field_type_textarea', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('email');
        $fieldType->setLabel('E-mailadres');
        $manager->persist($fieldType);

        $this->addReference('field_type_email', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('phone_number');
        $fieldType->setLabel('Telefoonnummer');
        $manager->persist($fieldType);

        $this->addReference('field_type_phone_number', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('date');
        $fieldType->setLabel('Datum');
        $manager->persist($fieldType);

        $this->addReference('field_type_date', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('checkbox');
        $fieldType->setLabel('Checkbox');
        $manager->persist($fieldType);

        $this->addReference('field_type_checkbox', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('radio');
        $fieldType->setLabel('Radio');
        $manager->persist($fieldType);

        $this->addReference('field_type_radio', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('dropdown');
        $fieldType->setLabel('Dropdown');
        $manager->persist($fieldType);

        $this->addReference('field_type_dropdown', $fieldType);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
