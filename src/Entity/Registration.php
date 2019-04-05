<?php
namespace App\Entity;


class Registration
{
    protected $Email;
    protected $Password;
    protected $FName;
    protected $MInit;
    protected $LName;

    protected $State;
    protected $City;
    protected $ZIP;
    protected $Street;
    protected $ApartmentNo;

    // Email
    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($Email){
        $this->Email = $Email;
    }

    // Password
    public function getPassword()
    {
        return $this->Password;
    }

    public function setPassword($Password){
        $this->Password = $Password;
    }

    // FName
    public function getFName()
    {
        return $this->FName;
    }

    public function setFName($FName){
        $this->FName = $FName;
    }

    // LName
    public function getLName()
    {
        return $this->LName;
    }

    public function setLName($LName){
        $this->LName = $LName;
    }

    // MInit
    public function getMInit()
    {
        return $this->MInit;
    }

    public function setMInit($MInit){
        $this->MInit = $MInit;
    }

    // State
    public function getState()
    {
        return $this->State;
    }

    public function setState($State){
        $this->State = $State;
    }

    // City
    public function getCity()
    {
        return $this->City;
    }

    public function setCity($City){
        $this->City = $City;
    }

    // ZIP
    public function getZIP()
    {
        return $this->ZIP;
    }

    public function setZIP($ZIP){
        $this->ZIP = $ZIP;
    }

    // Street
    public function getStreet()
    {
        return $this->Street;
    }

    public function setStreet($Street){
        $this->Street = $Street;
    }

    // ApartmentNo
    public function getApartmentNo()
    {
        return $this->ApartmentNo;
    }

    public function setApartmentNo($ApartmentNo = null){
        $this->ApartmentNo = $ApartmentNo;
    }
}
