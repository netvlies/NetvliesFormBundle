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

class SliderType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('min', $options['min']);
        $builder->setAttribute('max', $options['max']);
        $builder->setAttribute('stepping', $options['stepping']);
    }

    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        $view->set('min', $form->getAttribute('min'));
        $view->set('max', $form->getAttribute('max'));
        $view->set('stepping', $form->getAttribute('stepping'));
    }


    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'min'       => 0,
            'max'       => 100,
            'stepping'  => 1,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nvs_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'form';
    }
}