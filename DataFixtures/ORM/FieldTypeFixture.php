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
        $fieldType->setLabel('Text (single line)');
        $manager->persist($fieldType);

        $this->addReference('field_type_text', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('textarea');
        $fieldType->setLabel('Text area');
        $manager->persist($fieldType);

        $this->addReference('field_type_textarea', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('email');
        $fieldType->setLabel('Email address');
        $manager->persist($fieldType);

        $this->addReference('field_type_email', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('date');
        $fieldType->setLabel('Date');
        $manager->persist($fieldType);

        $this->addReference('field_type_date', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('checkbox');
        $fieldType->setLabel('Checkbox');
        $manager->persist($fieldType);

        $this->addReference('field_type_checkbox', $fieldType);

        $fieldType = new FieldType();
        $fieldType->setTag('radio');
        $fieldType->setLabel('Radio select');
        $manager->persist($fieldType);

        $this->addReference('field_type_radio', $fieldType);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
