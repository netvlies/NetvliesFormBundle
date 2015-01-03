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
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FieldAdmin extends Admin
{
    protected $formAdmin;

    protected $translationDomain = 'NetvliesFormBundle';

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_by' => 'position',
        '_sort_order' => 'ASC',
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
                    'attr' => array('class' => 'field_type'),
                )
            );

        if (!$editInline) {
            $formMapper
                ->add('selectType', 'sonata_type_translatable_choice', array(
                    'label' => 'admin.field.field.name.selecttype',
                    'required' => true,
                    'choices' => Field::getSelectTypes(),
                    'catalogue' => $this->translationDomain,
                    'attr' => array('class' => 'field_select_type'), ))
                ->add('selectMultiple', 'checkbox', array(
                    'label' => 'admin.field.field.name.selectmultiple',
                    'required' => false,
                    'attr' => array('class' => 'field_select_multiple'),
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
                );
        }

        if ($editInline) {
            $formMapper
                ->add('position', null, array('label' => 'admin.field.field.name.position'));
        }

        $formMapper->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label', null, array('label' => 'admin.field.field.name.label'))
            ->add('form', null, array('label' => 'admin.field.field.name.form'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('label');
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

    /**
     * A list of all fields for all forms is kind of useless, we want to return to the parent form in which this field is included, so we remove
     * the 'back to list' route and re-add it with parent form entries. Note that id must be filled with the form id instead of the field id.
     * this is taken care of in the generateObjectUrl override
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('netvlies.admin.form.field.list');

        $formCollection = new RouteCollection('netvlies.form.form.admin', 'admin_bundle_form_form', '/bundle/form/form', 'NetvliesFormBundle:FormAdmin');
        $formCollection->add('netvlies.admin.form.field.list', '{id}/edit');
        $collection->addCollection($formCollection);
    }

    /**
     *
     * This is to create the correct route when going back to the form edit instead of the field list
     *
     * @param string $name
     * @param mixed  $object
     * @param array  $parameters
     *
     * @return string return a complete url
     */
    public function generateObjectUrl($name, $object, array $parameters = array(), $absolute = false)
    {
        if ($name != 'list') {
            return parent::generateObjectUrl($name, $object, $parameters, $absolute);
        }

        return parent::generateObjectUrl($name, $object->getForm(), $parameters, $absolute);
    }

    /**
     * Add specific validation when default for type = date is entered
     */
    public function validate(ErrorElement $errorElement, $field)
    {
        if ($field->getType() == 'date') {
            $formatter = new \IntlDateFormatter(null, null, null);
            $formatter->setPattern('d-M-y');

            if (!$formatter->parse($field->getDefault())) {
                $errorElement->with('default')->addViolation('Dit is geen geldige standaardwaarde voor datum volgens formaat dag-maand-jaar');
            }
        }
    }
}
