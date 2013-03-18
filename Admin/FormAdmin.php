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
            ->with('General')
                ->add('label')
                ->add('successAction', 'choice', array(
                    'required' => true,
                    'choices' => array(
                        'url' => 'Redirect',
                        'message' => 'Message'
                    ),
                    'attr' => array('class' => 'form_success_action')))
                ->add('successUrl', null, array('label' => 'Success URL', 'required' => true, 'attr' => array('class' => 'form_success_url')))
                ->add('successMessage', null, array('label' => 'Success message', 'required' => true, 'attr' => array('class' => 'form_success_message')))
            ->end()
            ->with('Field management')
                ->add('fields', 'sonata_type_collection',
                    array(
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
            ->with('Email settings')
                ->add('sendMail', null, array('label' => 'Send mail', 'attr' => array('class' => 'form_mail_toggle')))
                ->add('mailRecipientName', null, array('label' => 'Recipient name', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailRecipientEmail', null, array('label' => 'Recipient email', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailSubject', null, array('label' => 'Mail subject', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailBody', null, array('label' => 'Mail body', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailSenderName', null, array('label' => 'Sender name', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
                ->add('mailSenderEmail', null, array('label' => 'Sender email', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
            ->end()
            ->with('Result handling')
                ->add('storeResults', null, array('label' => 'Store results'))
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

    public function getTemplatezz($name)
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
