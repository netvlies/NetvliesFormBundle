<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @Assert\Callback(methods={"validateContact"})
 * @ORM\Entity
 * @ORM\Table(name="fb_form")
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

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $successUrl;

    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="form", cascade={"persist"})
     */
    protected $fields;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="form", cascade={"persist"})
     */
    protected $results;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $addCaptcha = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $storeResult = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $sendMail = false;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $contactName;

    /**
     * @Assert\Email(groups={"contact"})
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $contactEmail;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mailSubject;

    /**
     * @Assert\NotBlank(groups={"contact"})
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mailContent;

    /**
     * @var
     */
    protected $sf2Form;

    /**
     * @param  $sf2Form
     */
    public function setSf2Form($sf2Form)
    {
        $this->sf2Form = $sf2Form;
    }

    /**
     * @return
     */
    public function getSf2Form()
    {
        return $this->sf2Form;
    }

    /**
     * Makes sure the contact validation is only performed when a mail should
     * be sent.
     *
     * @param ExecutionContext $executionContext
     */
    public function validateContact(ExecutionContext $executionContext)
    {
        if ($this->sendMail) {
            $executionContext->getGraphWalker()->walkReference($this, 'contact', $executionContext->getPropertyPath(), true);
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function __toString()
    {
        return $this->label;
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

    /**
     * Set storeResult
     *
     * @param boolean $storeResult
     * @return Form
     */
    public function setStoreResult($storeResult)
    {
        $this->storeResult = $storeResult;
    
        return $this;
    }

    /**
     * Get storeResult
     *
     * @return boolean 
     */
    public function getStoreResult()
    {
        return $this->storeResult;
    }

    /**
     * Set sendMail
     *
     * @param boolean $sendMail
     * @return Form
     */
    public function setSendMail($sendMail)
    {
        $this->sendMail = $sendMail;
    
        return $this;
    }

    /**
     * Get sendMail
     *
     * @return boolean
     */
    public function getSendMail()
    {
        return $this->sendMail;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     * @return Form
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    
        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return Form
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    
        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }
    
    /**
     * Add fields
     *
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
     * Remove fields
     *
     * @param Field $field
     */
    public function removeField(Field $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return ArrayCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set mailSubject
     *
     * @param string $mailSubject
     * @return Form
     */
    public function setMailSubject($mailSubject)
    {
        $this->mailSubject = $mailSubject;
    
        return $this;
    }

    /**
     * Get mailSubject
     *
     * @return string 
     */
    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    /**
     * Set mailContent
     *
     * @param string $mailContent
     * @return Form
     */
    public function setMailContent($mailContent)
    {
        $this->mailContent = $mailContent;
    
        return $this;
    }

    /**
     * Get mailContent
     *
     * @return string 
     */
    public function getMailContent()
    {
        return $this->mailContent;
    }

    /**
     * Add results
     *
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
     * Remove result
     *
     * @param Result $result
     */
    public function removeResult(Result $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get results
     *
     * @return ArrayCollection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set successUrl
     *
     * @param string $successUrl
     * @return Form
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;
    
        return $this;
    }

    /**
     * Get successUrl
     *
     * @return string 
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }
}