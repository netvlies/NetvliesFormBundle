<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @Assert\Callback(methods={"validateContact"})
 * @ORM\Entity
 * @ORM\Table(name="netvlies_formbundle_form")
 */
class Form
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $label;

    protected $success = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $successAction;

    /**
     * @Assert\NotBlank(groups={"success_url"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $successUrl;

    /**
     * @Assert\NotBlank(groups={"success_message"})
     * @ORM\Column(type="text", nullable=true)
     */
    protected $successMessage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $sendMail = false;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailRecipientName;

    /**
     * @Assert\Email(groups={"contact"})
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailRecipientEmail;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailSubject;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mailBody;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailSenderName;

    /**
     * @Assert\Email(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailSenderEmail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $storeResults = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $addCaptcha = false;

    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="form", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    protected $fields;

    protected $sf2Form;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="form", cascade={"persist"})
     */
    protected $results;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccessAction($successAction)
    {
        $this->successAction = $successAction;

        return $this;
    }

    public function getSuccessAction()
    {
        return $this->successAction;
    }

    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    public function setSuccessMessage($successMessage)
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    public function getSuccessMessage()
    {
        return $this->successMessage;
    }

    public function setSendMail($sendMail)
    {
        $this->sendMail = $sendMail;

        return $this;
    }

    public function getSendMail()
    {
        return $this->sendMail;
    }

    public function setMailRecipientName($mailRecipientName)
    {
        $this->mailRecipientName = $mailRecipientName;

        return $this;
    }

    public function getMailRecipientName()
    {
        return $this->mailRecipientName;
    }

    public function setMailRecipientEmail($mailRecipientEmail)
    {
        $this->mailRecipientEmail = $mailRecipientEmail;

        return $this;
    }

    public function getMailRecipientEmail()
    {
        return $this->mailRecipientEmail;
    }

    public function setMailSubject($mailSubject)
    {
        $this->mailSubject = $mailSubject;

        return $this;
    }

    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    public function setMailBody($mailBody)
    {
        $this->mailBody = $mailBody;

        return $this;
    }

    public function getMailBody()
    {
        return $this->mailBody;
    }

    public function setMailSenderName($mailSenderName)
    {
        $this->mailSenderName = $mailSenderName;

        return $this;
    }

    public function getMailSenderName()
    {
        return $this->mailSenderName;
    }

    public function setMailSenderEmail($mailSenderEmail)
    {
        $this->mailSenderEmail = $mailSenderEmail;

        return $this;
    }

    public function getMailSenderEmail()
    {
        return $this->mailSenderEmail;
    }

    public function setStoreResults($storeResults)
    {
        $this->storeResults = $storeResults;

        return $this;
    }

    public function getStoreResults()
    {
        return $this->storeResults;
    }

    public function setAddCaptcha($addCaptcha)
    {
        $this->addCaptcha = $addCaptcha;

        return $this;
    }

    public function getAddCaptcha()
    {
        return $this->addCaptcha;
    }

    public function addField(Field $field)
    {
        $field->setForm($this);

        $this->fields[] = $field;

        return $this;
    }

    public function removeField(Field $field)
    {
        $this->fields->removeElement($field);

        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setSf2Form($sf2Form)
    {
        $this->sf2Form = $sf2Form;

        return $this;
    }

    public function getSf2Form()
    {
        return $this->sf2Form;
    }

    public function addResult(Result $result)
    {
        $result->setForm($this);

        $this->results[] = $result;

        return $this;
    }

    public function removeResult(Result $result)
    {
        $this->results->removeElement($result);

        return $this;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function validateContact(ExecutionContext $executionContext)
    {
        if ($this->sendMail) {
            $executionContext->getGraphWalker()->walkReference($this, 'contact', $executionContext->getPropertyPath(), true);
        }
        if ($this->successAction == 'url') {
            $executionContext->getGraphWalker()->walkReference($this, 'success_url', $executionContext->getPropertyPath(), true);
        } else {
            $executionContext->getGraphWalker()->walkReference($this, 'success_message', $executionContext->getPropertyPath(), true);
        }
    }

    public function __toString()
    {
        return $this->label;
    }
}
