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
use Netvlies\Bundle\NetvliesFormBundle\Entity\Entry;
use Netvlies\Bundle\NetvliesFormBundle\Entity\Form;
use Netvlies\Bundle\NetvliesFormBundle\Entity\Result;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SuccessListener extends ContainerAware
{
    /**
     * Default handling for the form success event. This includes storage of
     * the result, sending a confirmation mail and redirecting to the success
     * URL, while respecting the form settings.
     *
     * @param FormEvent $event
     */
    public function onFormSuccess(FormEvent $event)
    {
        $form = $event->getForm();

        $result = $this->createResult($form);

        if ($form->getStoreResults()) {
            $this->storeResult($form, $result);
        }

        if ($form->getSendMail()) {
            $this->sendMail($form, $result);
        }

        $successUrl = $form->getSuccessUrl();

        if ($successUrl != null) {
            $redirectResponse = new RedirectResponse($successUrl);
            $redirectResponse->send();
        }
    }

    /**
     * Creates the result object from the user's input.
     *
     * @param $form
     * @return Result
     */
    public function createResult(Form $form)
    {
        $result = new Result();
        $result->setDatetimeAdded(new \DateTime());

        $viewData = $form->getSf2Form()->getViewData();

        foreach ($form->getFields() as $field) {
            $entry = new Entry();
            $entry->setField($field);
            $entry->setValue($viewData['field_'.$field->getId()]);
            $result->addEntry($entry);
        }

        return $result;
    }

    /**
     * Stores the user input as a result object.
     *
     * @param $form
     * @param $result
     */
    public function storeResult(Form $form, Result $result)
    {
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $form->addResult($result);
        $entityManager->persist($form);
        $entityManager->flush();
    }

    /**
     * Sends a mail containing the form values to the contact e-mail address
     * specified.
     *
     * @param Form   $form
     * @param Result $result
     */
    public function sendMail(Form $form, Result $result)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($form->getMailSubject())
            ->setTo(array($form->getMailRecipientEmail() => $form->getMailRecipientName()))
            ->setBody($this->container->get('templating')->render('NetvliesFormBundle:Mail:result.html.twig', array(
                'content' => $form->getMailBody(),
                'entries' => $result->getEntries(),
            )), 'text/html');

        if ($form->getMailSenderName() != null && $form->getMailSenderEmail() != null) {
            $message->setFrom(array($form->getMailSenderEmail() => $form->getMailSenderName()));
        }

        $this->container->get('mailer')->send($message);

        $transport = $this->container->get('mailer')->getTransport();
        if (!$transport instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $spool = $transport->getSpool();
        if (!$spool instanceof \Swift_MemorySpool) {
            return;
        }

        $spool->flushQueue($this->container->get('swiftmailer.transport.real'));
    }
}
