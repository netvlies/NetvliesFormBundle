<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Netvlies\Bundle\FormBundle\Entity\Form;
use Netvlies\Bundle\FormBundle\Entity\Option;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="netvlies_form_field")
 */
class Field
{
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_EMAIL = 'email';
    const TYPE_DATE = 'date';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_SELECT = 'select';

    const SELECT_TYPE_DROPDOWN = 'dropdown';
    const SELECT_TYPE_RADIO = 'radio';

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

    /**
     *
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
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
     * @return Field
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
     * @param $type
     * @return Field
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $selectType
     * @return Field
     */
    public function setSelectType($selectType)
    {
        $this->selectType = $selectType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectType()
    {
        return $this->selectType;
    }

    /**
     * @param $selectMultiple
     * @return Field
     */
    public function setSelectMultiple($selectMultiple)
    {
        $this->selectMultiple = $selectMultiple;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSelectMultiple()
    {
        return $this->selectMultiple;
    }

    /**
     * @param $required
     * @return Field
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param $default
     * @return Field
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param Option $option
     * @return Field
     */
    public function addOption(Option $option)
    {
        $option->setField($this);

        $this->options[] = $option;

        return $this;
    }

    /**
     * @param Option $option
     * @return Field
     */
    public function addOptions(Option $option)
    {
        $option->setField($this);

        $this->options[] = $option;

        return $this;
    }

    /**
     * @param Option $option
     */
    public function removeOption(Option $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $position
     * @return Field
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Form $form
     * @return Field
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    public static function getTypes()
    {
        return array(
            self::TYPE_TEXT => 'Tekst (één regel)',
            self::TYPE_TEXTAREA => 'Tekstblok',
            self::TYPE_EMAIL => 'E-mailadres',
            self::TYPE_DATE => 'Datum',
            self::TYPE_CHECKBOX => 'Checkbox',
            self::TYPE_SELECT => 'Selectie'
        );
    }

    public static function getSelectTypes()
    {
        return array(
            self::SELECT_TYPE_DROPDOWN => 'Drop-down',
            self::SELECT_TYPE_RADIO => 'Radio buttons'
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
