<?php

namespace Netvlies\Bundle\FormBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilder;

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
        $form = $this->container->get('netvlies_form.helper')->get($id);

        $sf2Form = $form->getSf2Form();

        return $this->container->get('templating')->render('NetvliesFormBundle:Form:show.html.twig', array(
            'id' => $form->getId(),
            'form' => $sf2Form->createView(),
        ));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    function getName()
    {
        return 'form_extension';
    }
}