<?php

namespace Netvlies\Bundle\FormBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class FormAdmin extends Admin
{
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_by' => 'label',
        '_sort_order' => 'ASC'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('label')
            ->add('storeResult', null, array('label' => 'Store result'))
            ->add('sendMail', null, array('label' => 'Send mail'))
            ->add('successUrl', null, array('label' => 'Success URL', 'required' => false))
            ->add('contactName', null, array('label' => 'Contact name', 'required' => false))
            ->add('contactEmail', null, array('label' => 'Contact email', 'required' => false))
            ->add('mailSubject', null, array('label' => 'Mail subject', 'required' => false))
            ->add('mailContent', null, array('label' => 'Mail content', 'required' => false))
            ->add('addCaptcha', null, array('label' => 'Use CAPTCHA'))
            ->add('fields', 'sonata_type_collection',
                array(
                    'required' => false,
                    'by_reference' => true,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                )
            )
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
