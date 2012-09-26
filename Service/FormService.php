<?php

namespace Netvlies\Bundle\FormBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Netvlies\Bundle\FormBundle\Entity\Entry;
use Netvlies\Bundle\FormBundle\Entity\Result;

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
     * @return null
     */
    public function get($id)
    {
        if (isset($forms[$id])) {
            return $this->forms[$id];
        }

        $contentRepository = $this->container->get('doctrine')->getRepository('NetvliesFormBundle:Form');
        $form = $contentRepository->findOneById($id);

        if ($form === null) {
            return null;
        }

        $formBuilder = $this->container->get('form.factory')->createBuilder();

        foreach ($form->getFields() as $field) {
            $formBuilder->add('field_'.$field->getId(), $field->getType()->getTag(), array('label' => $field->getLabel()));

        }

        $form->setSf2Form($formBuilder->getForm());

        $forms[$id] = $form;

        $this->handle($form);

        return $form;
    }

    /**
     * Checks if a post request was made. If so, it validates the form input
     * and upon success stores the result and sends the mail, depending on
     * the desired actions specified for the form.
     *
     * @param $form
     */
    public function handle($form)
    {
        $request = Request::createFromGlobals();

        $sf2Form = $form->getSf2Form();

        if ($request->getMethod() == 'POST') {

            $sf2Form->bind($request);

            if ($sf2Form->isValid()) {

                $result = $this->createResult($form);

                if ($form->getStoreResult()) {
                    $this->storeResult($form, $result);
                }

                if ($form->getSendMail()) {
                    $this->sendMail($form, $result);
                }

                if ($form->getSuccessUrl()) {
                    $router = $this->container->get('router');
                    return $router->redirect($form->getSuccessUrl());
                }
            }
        }
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
            )), 'text/html')
        ;
        $this->container->get('mailer')->send($message);

    }
}