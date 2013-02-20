<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Netvlies\Bundle\FormBundle\Entity\Forms;
use Netvlies\Bundle\FormBundle\Entity\Option;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="netvlies_formbundle_field")
 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $selectType;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $selectMultiple = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $required = false;

    /**
     * @ORM\Column(name="defaultValue", type="string", length=255, nullable=true)
     */
    protected $default;

    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="field", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    protected $options;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $position;

    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="fields", cascade={"persist"})
     */
    protected $form;

    public function __construct()
    {
        $this->options = new ArrayCollection();
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

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setSelectType($selectType)
    {
        $this->selectType = $selectType;

        return $this;
    }

    public function getSelectType()
    {
        return $this->selectType;
    }

    public function setSelectMultiple($selectMultiple)
    {
        $this->selectMultiple = $selectMultiple;

        return $this;
    }

    public function getSelectMultiple()
    {
        return $this->selectMultiple;
    }

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function addOption(Option $option)
    {
        $option->setField($this);

        $this->options[] = $option;

        return $this;
    }

    public function removeOption(Option $option)
    {
        $this->options->removeElement($option);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function __toString()
    {
        return $this->label;
    }
}
