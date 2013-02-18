<?php

namespace Netvlies\Bundle\FormBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FieldAdmin extends Admin
{
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_by' => 'position',
        '_sort_order' => 'ASC'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $adminAttributes = $formMapper->getFormBuilder()->getAttribute('sonata_admin');
        $editInline = isset($adminAttributes['edit']) && $adminAttributes['edit'] == 'inline';

        $formMapper
            ->add('label')
            ->add('type', 'choice', array(
                'required' => true,
                'choices' => array(
                    'text' => 'Text (single line)',
                    'textarea' => 'Textarea',
                    'email' => 'Email address',
                    'date' => 'Date',
                    'checkbox' => 'Checkbox',
                    'radio' => 'Radio select',
                    'dropdown' => 'Drop-down'
                ),
                'attr' => array('class' => 'field_type')))
        ;

        if (!$editInline) {
            $formMapper
                ->add('required', null, array('attr' => array('class' => 'field_required')))
                ->add('default', null, array('label' => 'Default value', 'attr' => array('class' => 'field_default')))
                ->add('options', 'sonata_type_collection',
                    array(
                        'required' => false,
                        'by_reference' => false,
                        'attr' => array('class' => 'field_options'), // looks like this doesn't work
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
            ;
        }

        if ($editInline) {
            $formMapper
                ->add('position')
            ;
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('label')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label')
            ->add('type')
            ->add('position')
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'NetvliesFormBundle:FieldAdmin:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
