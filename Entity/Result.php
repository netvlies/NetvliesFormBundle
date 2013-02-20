<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="netvlies_formbundle_result")
 */
class Result
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetimeAdded;

    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="results", cascade={"persist"})
     */
    protected $form;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="result", cascade={"persist"})
     */
    protected $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDatetimeAdded($datetimeAdded)
    {
        $this->datetimeAdded = $datetimeAdded;

        return $this;
    }

    public function getDatetimeAdded()
    {
        return $this->datetimeAdded;
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

    public function addEntry(Entry $entry)
    {
        $entry->setResult($this);

        $this->entries[] = $entry;

        return $this;
    }

    public function removeEntry(Entry $entry)
    {
        $this->entries->removeElement($entry);

        return $this;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function __toString()
    {
        return $this->id;
    }
}
