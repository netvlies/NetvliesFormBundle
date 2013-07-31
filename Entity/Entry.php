<?php

/*
 * (c) Netvlies Internetdiensten
 *
 * Jeroen van den Enden <jvdenden@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Netvlies\Bundle\NetvliesFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="netvlies_form_entry")
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
     * @ORM\Column(type="text", nullable=true)
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

    public function getId()
    {
        return $this->id;
    }

    public function setValue($value)
    {
        if (is_array($value)) {
            $value = serialize($value);
        }

        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        $value = @unserialize($this->value);
        if (is_array($value)) {
            $this->value = $value;
        }

        return $this->value;
    }

    public function setField(Field $field)
    {
        $this->field = $field;

        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setResult(Result $result)
    {
        $this->result = $result;

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function __toString()
    {
        return strval($this->value);
    }
}
