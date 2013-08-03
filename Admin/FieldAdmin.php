<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\Admin;

use Netvlies\Bundle\NetvliesFormBundle\Entity\Field;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FieldAdmin extends Admin
{
    protected $formAdmin;

    protected $translationDomain = 'NetvliesFormBundle';

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
            ->with('admin.field.section.general')
                ->add('label', null, array('label' => 'admin.field.field.name.label'))
                ->add('type', 'sonata_type_translatable_choice', array(
                    'label' => 'admin.field.field.name.type',
                    'required' => true,
                    'choices' => Field::getTypes(),
                    'catalogue' => $this->translationDomain,
                    'attr' => array('class' => 'field_type')
                )
            )
        ;

        if (!$editInline) {
            $formMapper
                ->add('selectType', 'sonata_type_translatable_choice', array(
                    'label' => 'admin.field.field.name.selecttype',
                    'required' => true,
                    'choices' => Field::getSelectTypes(),
                    'catalogue' => $this->translationDomain,
                    'attr' => array('class' => 'field_select_type')))
                ->add('selectMultiple', 'checkbox', array(
                    'label' => 'admin.field.field.name.selectmultiple',
                    'required' => false,
                    'attr' => array('class' => 'field_select_multiple')
                ))
                ->add('required', null, array('label' => 'admin.field.field.name.required', 'attr' => array('class' => 'field_required')))
                ->add('default', null, array('label' => 'admin.field.field.name.default', 'attr' => array('class' => 'field_default')))
                ->add('options', 'sonata_type_collection',
                    array(
                        'label' => 'admin.field.field.name.options',
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
                ->add('position', null, array('label' => 'admin.field.field.name.position'))
            ;
        }

        $formMapper->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label', null, array('label' => 'admin.field.field.name.label'))
            ->add('form', null, array('label' => 'admin.field.field.name.form'))
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
        if ($this->getConfigurationPool()->getContainer()->get('request')->request->has('btn_update_and_list')) {
            $this->redirectToForm($field->getForm()->getId());
        }
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
