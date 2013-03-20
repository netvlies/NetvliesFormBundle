<?php

namespace Netvlies\Bundle\FormBundle\Admin;

use Netvlies\Bundle\FormBundle\Entity\Form;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class FormAdmin extends Admin
{
    protected $translationDomain = 'NetvliesFormBundle';

    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_by' => 'label',
        '_sort_order' => 'ASC'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Algemeen')
                ->add('label', null, array('label' => 'Naam'))
                ->add('successAction', 'sonata_type_translatable_choice', array(
                    'label' => 'Actie na succes',
                    'required' => true,
                    'choices' => Form::getSuccessActions(),
                    'catalogue' => $this->translationDomain,
                    'attr' => array('class' => 'form_success_action')))
                ->add('successUrl', null, array('label' => 'URL', 'required' => true, 'attr' => array('class' => 'form_success_url')))
                ->add('successMessage', null, array('label' => 'Bericht', 'required' => true, 'attr' => array('class' => 'form_success_message')))
            ->end()
            ->with('Beheer velden')
                ->add('fields', 'sonata_type_collection',
                    array(
                        'label' => 'Velden',
                        'required' => false,
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
//                        'sortable' => 'position',
                    )
                )
                ->add('addCaptcha', null, array('label' => 'Add CAPTCHA'))
            ->end()
            ->with('E-mailinstellingen')
                ->add('sendMail', null, array('label' => 'Stuur een e-mail', 'attr' => array('class' => 'form_mail_toggle')))
                ->add('mailRecipientName', null, array('label' => 'Naam ontvanger', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailRecipientEmail', null, array('label' => 'E-mailadres ontvanger', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailSubject', null, array('label' => 'Onderwerp e-mail', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailBody', null, array('label' => 'Introtekst e-mail', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
                ->add('mailSenderName', null, array('label' => 'Naam afzender', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
                ->add('mailSenderEmail', null, array('label' => 'E-mailadres afzender', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
            ->end()
            ->with('Opslag gegevens')
                ->add('storeResults', null, array('label' => 'Bewaar gegevens'))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'results' => array('template' => 'NetvliesFormBundle:FormAdmin:list__action_results.html.twig'),
                )
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('results', $this->getRouterIdParameter().'/results');
    }

    public function getFormTheme()
    {
        return array('NetvliesFormBundle:FormAdmin:form_admin_fields.html.twig');
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'NetvliesFormBundle:FormAdmin:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
