<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fb_field")
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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    public function __toString()
    {
        return $this->label;
    }

    /**
     * Set form
     *
     * @param  Form  $form
     * @return Field
     */
    public function setForm(Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
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

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set position
     *
     * @param  integer $position
     * @return Field
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add options
     *
     * @param  \Netvlies\Bundle\FormBundle\Entity\Option $options
     * @return Field
     */
    public function addOption(\Netvlies\Bundle\FormBundle\Entity\Option $options)
    {
        $options->setField($this);

        $this->options[] = $options;

        return $this;
    }

    /**
     * Remove options
     *
     * @param \Netvlies\Bundle\FormBundle\Entity\Option $options
     */
    public function removeOption(\Netvlies\Bundle\FormBundle\Entity\Option $options)
    {
        $this->options->removeElement($options);
    }
}
