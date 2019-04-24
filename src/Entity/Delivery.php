<?php

namespace App\Entity;

class Delivery
{
    
    protected $Vehicle;
    protected $PackageID;
    protected $OfficeID;

    // Office
    public function getOffice()
    {
        return $this->Office;
    }

    public function setOffice($Office){
        $this->Office = $Office;
    }

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