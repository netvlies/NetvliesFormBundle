<?php

namespace Netvlies\Bundle\FormBundle\Service;

use Netvlies\Bundle\FormBundle\Event\FormEvent;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;

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
                $formBuilder->add('field_'.$field->getId(), $field->getType()->getTag(), array('label' => $field->getLabel()));
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
