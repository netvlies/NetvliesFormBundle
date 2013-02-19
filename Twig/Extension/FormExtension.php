<?php

namespace Netvlies\Bundle\FormBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'show_form' => new \Twig_Function_Method($this, 'showForm', array('is_safe' => array('html'))),
        );
    }

    /**
     * Twig function that displays the form with the requested ID.
     *
     * @param $id
     * @return mixed
     */
    public function showForm($id)
    {
        $form = $this->container->get('netvlies.form')->get($id);

        if ($form->getSuccess()) {
            return $this->container->get('templating')->render('NetvliesFormBundle:Twig:form_success.html.twig', array(
                'successMessage' => $form->getSuccessMessage()
            ));
        } else {
            return $this->container->get('templating')->render('NetvliesFormBundle:Twig:form_show.html.twig', array(
                'id' => $form->getId(),
                'form' => $form->getSf2Form()->createView()
            ));
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'form_extension';
    }
}
