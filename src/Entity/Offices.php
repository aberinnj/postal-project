<?php
namespace App\Entity;

class Offices
{
    protected $state;

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
}
