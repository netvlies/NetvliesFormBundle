<?php

namespace Netvlies\Bundle\FormBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class FormAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('label')
            ->add('addCaptcha')
            ->add('storeResult')
            ->add('sendMail')
            ->add('successUrl', null, array('required' => false))
            ->add('contactName', null, array('required' => false))
            ->add('contactEmail', null, array('required' => false))
            ->add('mailSubject', null, array('required' => false))
            ->add('mailContent', null, array('required' => false))
            ->add('fields', 'sonata_type_collection', array('required' => false), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'export' => array('template' => 'NetvliesFormBundle:Sonata:CRUD/list__action_export.html.twig'),
                )
            ))
        ;
    }
}
