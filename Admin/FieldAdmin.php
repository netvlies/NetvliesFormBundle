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
            ->add('type', 'sonata_type_model')
        ;

        // Do not show all fields when in inline editing mode
        if (!$editInline) {

            $formMapper
                ->add('required')
                ->add('default', null, array('label' => 'Default value'))
                ->add('options', 'sonata_type_collection',
                    array(
                        'required' => false,
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
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
