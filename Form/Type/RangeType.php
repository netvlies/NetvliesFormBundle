<?php
/**
 * @author Richard van den Brand <richard@netvlies.nl>
 * @copyright Netvlies Internetdiensten
 */

namespace Netvlies\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
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
        return 'nvs_slider';
    }
}