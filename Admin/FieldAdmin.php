<?php

namespace Netvlies\Bundle\FormBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FieldAdmin extends Admin
{
    protected $formAdmin;

    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_by' => 'position',
        '_sort_order' => 'ASC'
    );

    public function setFormAdmin($formAdmin)
    {
        $this->formAdmin = $formAdmin;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $adminAttributes = $formMapper->getFormBuilder()->getAttribute('sonata_admin');
        $editInline = isset($adminAttributes['edit']) && $adminAttributes['edit'] == 'inline';

        $formMapper
            ->with('General')
            ->add('label')
            ->add('type', 'choice', array(
                'required' => true,
                'choices' => array(
                    'text' => 'Text (single line)',
                    'textarea' => 'Textarea',
                    'email' => 'Email address',
                    'date' => 'Date',
                    'checkbox' => 'Checkbox',
                    'select' => 'Select'
                ),
                'attr' => array('class' => 'field_type')
            ))
        ;

        if (!$editInline) {

            $formMapper
                ->add('selectType', 'choice', array(
                    'required' => true,
                    'choices' => array(
                        'dropdown' => 'Drop-down',
                        'radio' => 'Radio buttons'
                    ),
                    'attr' => array('class' => 'field_select_type')))
                ->add('selectMultiple', 'checkbox', array(
                    'required' => false,
                    'attr' => array('class' => 'field_select_multiple')
                ))
                ->add('required', null, array('attr' => array('class' => 'field_required')))
                ->add('default', null, array('label' => 'Default value', 'attr' => array('class' => 'field_default')))
                ->add('options', 'sonata_type_collection',
                    array(
                        'required' => false,
                        'by_reference' => false,
                        'attr' => array('class' => 'field_options'),
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

        $formMapper->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label')
            ->add('form')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('label')
        ;
    }

    public function postUpdate($field)
    {
        $this->redirectToForm($field->getForm()->getId());
    }

    public function postRemove($field)
    {
        $this->redirectToForm($field->getForm()->getId());
    }

    protected function redirectToForm($formId)
    {
        $redirectUrl = $this->formAdmin->generateUrl('edit', array('id' => $formId));
        $response = new RedirectResponse($redirectUrl);
        $response->send();
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
