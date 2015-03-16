<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormService extends ContainerAware
{
    protected $forms = array();

    /**
     * Builds the form with the requested ID. When a form is requested for the
     * second time, the instance created earlier is returned to ensure only one
     * form instance is used and form properties can be set and retrieved from
     * all locations where the form is used.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        if (!isset($this->forms[$id])) {
            $contentRepository = $this->container->get('doctrine')->getRepository('NetvliesFormBundle:Form');
            $form = $contentRepository->findOneById($id);

            $formBuilder = $this->container->get('form.factory')->createBuilder();

            $formBuilder->add('form_id', 'hidden', array('data' => $id));

            foreach ($form->getFields() as $field) {
                $type = $field->getType();
                $options = array(
                    'label' => $field->getLabel(),
                    'constraints' => array(),
                );

                if ($field->getRequired()) {
                    $options['constraints'][] = new NotBlank();
                } else {
                    $options['required'] = false;
                }

                if ($field->getDefault()) {
                    $options['data'] = $field->getDefault();
                }

                switch ($field->getType()) {
                    case 'select':
                        $type = 'choice';
                        $options['expanded'] = ($field->getSelectType() != 'dropdown');
                        $options['multiple'] = $field->getSelectMultiple();
                        $options['choices'] = array();
                        foreach ($field->getOptions() as $option) {
                            $options['choices'][$option->getLabel()] = $option->getLabel();
                        }
                        if ($field->getDefault()) {
                            $options['data'] = $field->getDefault();
                            if ($options['multiple']) {
                                $options['data'] = explode(',', $options['data']);
                            }
                        }
                        break;
                    case 'email':
                        $options['constraints'][] = new Email();
                        break;
                    case 'date':
                        $options['widget'] = 'single_text';
                        $options['attr']['class'] = 'datepicker';
                        $options['attr']['placeholder'] = 'dd-mm-yyyy';
                        $options['input'] = 'string';
                        $options['format'] = 'd-M-y';
                        break;
                }
                $formBuilder->add('field_'.$field->getId(), $type, $options);
            }

            if ($form->getAddCaptcha()) {
                $formBuilder->add('captcha', 'captcha');
            }

            $form->setSf2Form($formBuilder->getForm());

            $this->forms[$id] = $form;
        }

        return $this->forms[$id];
    }
}
