<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fb_entry")
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Field", cascade={"persist"})
     */
    protected $field;

    /**
     * @ORM\ManyToOne(targetEntity="Result", inversedBy="entries", cascade={"persist"})
     */
    protected $result;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set result
     *
     * @param  Result $result
     * @return Entry
     */
    public function setResult(Result $result = null)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set field
     *
     * @param  Field $field
     * @return Entry
     */
    public function setField(Field $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set value
     *
     * @param  string $value
     * @return Entry
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
