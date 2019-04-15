<?php

namespace App\Entity;

class Delivery
{
    
    protected $Vehicle;
    protected $PackageID;

    // Vehicle
    public function getVehicle()
    {
        return $this->Vehicle;
    }

    public function setVehicle($Vehicle){
        $this->Vehicle = $Vehicle;
    }

    // PackageID
    public function getPackageID()
    {
        return $this->PackageID;
    }

    public function setPackageID($PackageID){
        $this->PackageID = $PackageID;
    }
}