<?php
namespace App\Entity;

class Tracking
{
    protected $PackageID;

    public function getPackageID()
    {
        return $this->PackageID;
    }

    public function setPackageID($PackageID)
    {
        $this->PackageID = $PackageID;
    }
}
