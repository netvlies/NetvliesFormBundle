<?php
namespace Netvlies\Bundle\FormBundle\EventListener;

use Netvlies\Bundle\FormBundle\Event\FormEvent;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class SubmitListener extends ContainerAware
{
    /**
     * Checks if a form post request was mad. If so, it validates the form input
     * and upon success dispatches the form success event, which can be used for
     * further custom handling of the received data.
     *
     * @param $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->isMethod('post')) {

            $formId = $request->request->getInt('form[form_id]', 0, true);

            if ($formId > 0) {

                $form = $this->container->get('netvlies.form')->get($formId);

                $sf2Form = $form->getSf2Form();

                $sf2Form->bind($request);

                if ($sf2Form->isValid()) {

                    $form->setSuccess(true);

                    $event = new FormEvent($form);

                    $dispatcher = $this->container->get('event_dispatcher');
                    $dispatcher->dispatch('form.success', $event);
                }
            }
        }
    }
}
