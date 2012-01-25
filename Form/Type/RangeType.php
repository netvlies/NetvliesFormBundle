<?php
/**
 * @author Richard van den Brand <richard@netvlies.nl>
 * @copyright Netvlies Internetdiensten
 */

namespace Netvlies\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class RangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        $view->set('min', $form->getAttribute('min'));
        $view->set('max', $form->getAttribute('max'));
        $view->set('stepping', $form->getAttribute('stepping'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('min', $options['min']);
        $builder->setAttribute('max', $options['max']);
        $builder->setAttribute('stepping', $options['stepping']);

        $builder
            ->add('start', 'hidden')
            ->add('end', 'hidden')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nvs_range';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'netvlies_form_slider';
    }
}