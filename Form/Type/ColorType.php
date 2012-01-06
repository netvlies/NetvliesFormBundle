<?php
/**
 * @author Richard van den Brand <richard@netvlies.nl>
 * @copyright Netvlies Internetdiensten
 */

namespace Netvlies\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ColorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'attr'  => array(
                'class' => 'color'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nvs_color';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'text';
    }
}