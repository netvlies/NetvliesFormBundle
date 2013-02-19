<?php

namespace Netvlies\Bundle\FormBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

class FormService extends ContainerAware
{
    /**
     * @var array
     */
    protected $forms = array();

    /**
     * Returns the form with the requested ID. When the form is requested for
     * the first time,
     *
     * @param $id
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
                $options = array('label' => $field->getLabel());
                // @todo create better extension mechanism and replace case statement
                switch ($field->getType()) {
                    case 'select':
                        $type = 'choice';
                        $options['expanded'] = ($field->getSelectType() != 'dropdown');
                        $options['choices'] = array();
                        foreach ($field->getOptions() as $option) {
                            $options['choices'][$option->getLabel()] = $option->getLabel();
                        }
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
