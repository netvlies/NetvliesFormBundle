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

use Netvlies\Bundle\NetvliesFormBundle\Entity\Form;
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
        '_sort_order' => 'ASC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.form.section.general')
                ->add('label', null, array('label' => 'admin.form.field.name.label'))
                ->add('successAction', 'sonata_type_translatable_choice', array(
                    'label' => 'admin.form.field.name.successaction',
                    'required' => true,
                    'choices' => Form::getSuccessActions(),
                    'catalogue' => $this->translationDomain,
                    'attr' => array('class' => 'form_success_action'), ))
                ->add('successUrl', null, array('label' => 'admin.form.field.name.successurl', 'required' => true, 'attr' => array('class' => 'form_success_url')))
                ->add('successMessage', null, array('label' => 'admin.form.field.name.successmessage', 'required' => true, 'attr' => array('class' => 'form_success_message')))
            ->end()
            ->with('admin.form.section.fields')
                ->add('fields', 'sonata_type_collection',
                    array(
                        'label' => 'admin.form.field.name.fields',
                        'required' => false,
                        'by_reference' => false,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
                ->add('addCaptcha', null, array('label' => 'admin.form.field.name.captcha')
            )
            ->end()
            ->with('admin.form.section.mail')
                ->add('sendMail', null, array('label' => 'admin.form.field.name.sendmail', 'attr' => array('class' => 'form_mail_toggle')))
                ->add('mailRecipientName', null, array('label' => 'admin.form.field.name.mailrecipientname', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailRecipientEmail', null, array('label' => 'admin.form.field.name.mailrecipientemail', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailSubject', null, array('label' => 'admin.form.field.name.mailsubject', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailBody', null, array('label' => 'admin.form.field.name.mailbody', 'attr' => array('class' => 'form_mail_related'), 'required' => false))
                ->add('mailSenderName', null, array('label' => 'admin.form.field.name.mailsendername', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
                ->add('mailSenderEmail', null, array('label' => 'admin.form.field.name.mailsenderemail', 'attr' => array('class' => 'form_mail_related'), 'required' => true))
            ->end()
            ->with('admin.form.section.results')
                ->add('storeResults', null, array('label' => 'admin.form.field.name.results'))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('label', null, array('label' => 'admin.form.list.label'))
            ->add('results', 'string', array('label' => 'admin.form.list.results', 'template' => 'NetvliesFormBundle:FormAdmin:results.html.twig'))
            ->add('viewResults', 'string', array('label' => 'admin.form.list.viewResults', 'template' => 'NetvliesFormBundle:FormAdmin:view_results.html.twig'))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('results', $this->getRouterIdParameter().'/results');
        $collection->add('viewResults', $this->getRouterIdParameter().'/view-results');
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
