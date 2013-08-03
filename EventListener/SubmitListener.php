<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\EventListener;

use Netvlies\Bundle\NetvliesFormBundle\Event\FormEvent;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

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
