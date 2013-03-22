<?php
namespace Netvlies\Bundle\NetvliesFormBundle\Event;

use Netvlies\Bundle\NetvliesFormBundle\Entity\Form;
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
