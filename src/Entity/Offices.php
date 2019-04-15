<?php
namespace App\Entity;

class Offices
{
    protected $OfficeID;

    public function getOfficeID()
    {
        return $this->OfficeID;
    }

    public function setOfficeID($OfficeID)
    {
        $this->OfficeID = $OfficeID;
    }
}
