<?php

namespace Netvlies\Bundle\FormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Netvlies\Bundle\FormBundle\Entity\Form;
use Netvlies\Bundle\FormBundle\Entity\Field;

class FormFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Contact form
        $form = new Form();
        $form->setLabel('Contactformulier');
        $form->addField($manager->merge($this->getReference('field_contact_name')));
        $form->addField($manager->merge($this->getReference('field_contact_email')));
        $form->addField($manager->merge($this->getReference('field_contact_message')));
        $manager->persist($form);

        // Application form
        $form = new Form();
        $form->setLabel('Sollicitatieformulier');
        $form->addField($manager->merge($this->getReference('field_application_name')));
        $form->addField($manager->merge($this->getReference('field_application_function')));
        $form->addField($manager->merge($this->getReference('field_application_motivation')));
        $manager->persist($form);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}