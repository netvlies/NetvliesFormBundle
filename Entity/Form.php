<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @Assert\Callback(methods={"validateContact"})
 * @ORM\Entity
 * @ORM\Table(name="netvlies_form_form")
 */
class Form
{
    const SUCCESS_ACTION_REDIRECT = 'redirect';
    const SUCCESS_ACTION_MESSAGE = 'message';

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $label
     * @return Form
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $success
     * @return Form
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param $successAction
     * @return Form
     */
    public function setSuccessAction($successAction)
    {
        $this->successAction = $successAction;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessAction()
    {
        return $this->successAction;
    }

    /**
     * @param $successUrl
     * @return Form
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param $successMessage
     * @return Form
     */
    public function setSuccessMessage($successMessage)
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }

    /**
     * @param $sendMail
     * @return Form
     */
    public function setSendMail($sendMail)
    {
        $this->sendMail = $sendMail;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSendMail()
    {
        return $this->sendMail;
    }

    /**
     * @param $mailRecipientName
     * @return Form
     */
    public function setMailRecipientName($mailRecipientName)
    {
        $this->mailRecipientName = $mailRecipientName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailRecipientName()
    {
        return $this->mailRecipientName;
    }

    /**
     * @param $mailRecipientEmail
     * @return Form
     */
    public function setMailRecipientEmail($mailRecipientEmail)
    {
        $this->mailRecipientEmail = $mailRecipientEmail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailRecipientEmail()
    {
        return $this->mailRecipientEmail;
    }

    /**
     * @param $mailSubject
     * @return Form
     */
    public function setMailSubject($mailSubject)
    {
        $this->mailSubject = $mailSubject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    /**
     * @param $mailBody
     * @return Form
     */
    public function setMailBody($mailBody)
    {
        $this->mailBody = $mailBody;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailBody()
    {
        return $this->mailBody;
    }

    /**
     * @param $mailSenderName
     * @return Form
     */
    public function setMailSenderName($mailSenderName)
    {
        $this->mailSenderName = $mailSenderName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailSenderName()
    {
        return $this->mailSenderName;
    }

    /**
     * @param $mailSenderEmail
     * @return Form
     */
    public function setMailSenderEmail($mailSenderEmail)
    {
        $this->mailSenderEmail = $mailSenderEmail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailSenderEmail()
    {
        return $this->mailSenderEmail;
    }

    /**
     * @param $storeResults
     * @return Form
     */
    public function setStoreResults($storeResults)
    {
        $this->storeResults = $storeResults;

        return $this;
    }

    /**
     * @return bool
     */
    public function getStoreResults()
    {
        return $this->storeResults;
    }

    /**
     * @param $addCaptcha
     * @return Form
     */
    public function setAddCaptcha($addCaptcha)
    {
        $this->addCaptcha = $addCaptcha;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAddCaptcha()
    {
        return $this->addCaptcha;
    }

    /**
     * @param Field $field
     * @return Form
     */
    public function addField(Field $field)
    {
        $field->setForm($this);

        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param Field $field
     * @return Form
     */
    public function addFields(Field $field)
    {
        $field->setForm($this);

        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param Field $field
     * @return Form
     */
    public function removeField(Field $field)
    {
        $this->fields->removeElement($field);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $sf2Form
     * @return Form
     */
    public function setSf2Form($sf2Form)
    {
        $this->sf2Form = $sf2Form;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSf2Form()
    {
        return $this->sf2Form;
    }

    /**
     * @param Result $result
     * @return Form
     */
    public function addResult(Result $result)
    {
        $result->setForm($this);

        $this->results[] = $result;

        return $this;
    }

    /**
     * @param Result $result
     * @return Form
     */
    public function removeResult(Result $result)
    {
        $this->results->removeElement($result);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param \Symfony\Component\Validator\ExecutionContext $executionContext
     */
    public function validateContact(ExecutionContext $executionContext)
    {
        if ($this->sendMail) {
            $executionContext->getGraphWalker()->walkReference($this, 'contact', $executionContext->getPropertyPath(), true);
        }
        if ($this->successAction == 'redirect') {
            $executionContext->getGraphWalker()->walkReference($this, 'success_url', $executionContext->getPropertyPath(), true);
        } else {
            $executionContext->getGraphWalker()->walkReference($this, 'success_message', $executionContext->getPropertyPath(), true);
        }
    }

    public static function getSuccessActions()
    {
        return array(
            self::SUCCESS_ACTION_REDIRECT => 'admin.form.field.successaction.option.redirect',
            self::SUCCESS_ACTION_MESSAGE => 'admin.form.field.successaction.option.message'
        );
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->label;
    }
}
