<?php
namespace Netvlies\Bundle\FormBundle\Event;

use Netvlies\Bundle\FormBundle\Entity\Form;
use Symfony\Component\EventDispatcher\Event;

class FormEvent extends Event
{
    protected $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}
