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

        $type = $options['show_controls'] == false ? 'hidden' : 'text';

        $builder
            ->add('start', $type, array(
                'attr' => array(
                        'data-type' => 'nvs-range-from',
                        'data-init' => $options['init_from']
                    )
            ))
            ->add('end', $type, array(
                'attr' => array(
                        'data-type' => 'nvs-range-to',
                        'data-init' => $options['init_to']
                    )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'init_from' => $options['min'],
            'init_to'   => $options['max']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'netvlies_form_range';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'netvlies_form_slider';
    }
}