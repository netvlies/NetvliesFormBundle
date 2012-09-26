<?php

namespace Netvlies\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fb_result")
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
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="results", cascade={"persist"})
     */
    protected $form;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="result", cascade={"persist"})
     */
    protected $entries;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetimeAdded;

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
     * Set form
     *
     * @param Form $form
     * @return Result
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }
    
    /**
     * Add entry
     *
     * @param Entry $entry
     * @return Result
     */
    public function addEntry(Entry $entry)
    {
        $entry->setResult($this);

        $this->entries[] = $entry;
    
        return $this;
    }

    /**
     * Remove entry
     *
     * @param Entry $entry
     */
    public function removeEntry(Entry $entry)
    {
        $this->entries->removeElement($entry);
    }

    /**
     * Get entries
     *
     * @return ArrayCollection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set datetimeAdded
     *
     * @param \DateTime $datetimeAdded
     * @return Result
     */
    public function setDatetimeAdded($datetimeAdded)
    {
        $this->datetimeAdded = $datetimeAdded;
    
        return $this;
    }

    /**
     * Get datetimeAdded
     *
     * @return \DateTime 
     */
    public function getDatetimeAdded()
    {
        return $this->datetimeAdded;
    }

    /**
     * Add entries
     *
     * @param Netvlies\Bundle\FormBundle\Entity\Entry $entries
     * @return Result
     */
    public function addEntrie(\Netvlies\Bundle\FormBundle\Entity\Entry $entries)
    {
        $this->entries[] = $entries;
    
        return $this;
    }

    /**
     * Remove entries
     *
     * @param Netvlies\Bundle\FormBundle\Entity\Entry $entries
     */
    public function removeEntrie(\Netvlies\Bundle\FormBundle\Entity\Entry $entries)
    {
        $this->entries->removeElement($entries);
    }
}