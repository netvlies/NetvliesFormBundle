<?php
namespace Netvlies\Bundle\FormBundle\EventListener;

use Netvlies\Bundle\FormBundle\Event\FormEvent;
use Netvlies\Bundle\FormBundle\Entity\Entry;
use Netvlies\Bundle\FormBundle\Entity\Result;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SuccessListener extends ContainerAware
{
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
        if ($successUrl == null) {
            $currentRoute = $this->container->get('request')->attributes->get('_route');
            $successUrl = $this->container->get('router')->generate($currentRoute, array('success' => 'true'), true);
            var_dump($successUrl);
            die;
        }

        $redirectResponse = new RedirectResponse($successUrl);
        $redirectResponse->send();
    }

    /**
     * Creates the result object from the user's input.
     *
     * @param $form
     * @return Result
     */
    public function createResult($form)
    {
        $result = new Result();
        $result->setDatetimeAdded(new \DateTime());

        $viewData = $form->getSf2Form()->getViewData();

        // Process entries
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
    public function storeResult($form, $result)
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
     * @param $form
     */
    public function sendMail($form, $result)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($form->getMailSubject())
            ->setTo(array($form->getContactEmail() => $form->getContactName()))
            ->setBody($this->container->get('templating')->render('NetvliesFormBundle:Mail:result.html.twig', array(
                'content' => $form->getMailContent(),
                'entries' => $result->getEntries(),
            )), 'text/html');

        $this->container->get('mailer')->send($message);
    }
}
