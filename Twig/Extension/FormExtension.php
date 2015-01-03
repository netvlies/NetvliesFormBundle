<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\Twig\Extension;

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
     * If the form post was successful, the success message is shown
     * by the Twig renderer.
     *
     * @param $id
     * @return mixed
     */
    public function showForm($id)
    {
        $form = $this->container->get('netvlies.form')->get($id);

        if ($form->getSuccess()) {
            return $this->container->get('templating')->render('NetvliesFormBundle:Twig:form_success.html.twig', array(
                'successMessage' => $form->getSuccessMessage(),
            ));
        } else {
            $formView = $form->getSf2Form()->createView();
            if ($this->container->getParameter('netvlies.form.templates.fields') != null) {
                $this->container->get('twig')->getExtension('form')->renderer->setTheme($formView, array($this->container->getParameter('netvlies.form.templates.fields')));
            }

            return $this->container->get('templating')->render($this->container->getParameter('netvlies.form.templates.form'), array(
                'id' => $form->getId(),
                'form' => $formView,
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
