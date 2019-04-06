<?php

namespace App\Entity;

class Package
{
    protected $Email;
    protected $Recipient;
    protected $Weight;
    protected $Length;
    protected $Width;
    protected $Height;


    protected $Street;
    protected $ApartmentNo;
    protected $City;
    protected $State;
    protected $ZIP;

    protected $isFragile;
    protected $Priority;

    // Email
    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($Email){
        $this->Email = $Email;
    }

    // Recipient
    public function getRecipient()
    {
        return $this->Recipient;
    }

    public function setRecipient($Recipient){
        $this->Recipient = $Recipient;
    }

    // Weight
    public function getWeight()
    {
        return $this->Weight;
    }

    public function setWeight($Weight){
        $this->Weight = $Weight;
    }
    // Height
    public function getHeight()
    {
        return $this->Height;
    }

    public function setHeight($Height){
        $this->Height = $Height;
    }    
    // Length
    public function getLength()
    {
        return $this->Length;
    }

    public function setLength($Length){
        $this->Length = $Length;
    }
    // Width
    public function getWidth()
    {
        return $this->Width;
    }

    public function setWidth($Width){
        $this->Width = $Width;
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

    // isFragile
    public function getIsFragile()
    {
        return $this->isFragile;
    }

    public function setIsFragile($isFragile){
        $this->isFragile = $isFragile;
    }

    // Priority
    public function getPriority()
    {
        return $this->Priority;
    }
    
    public function setPriority($Priority){
        $this->Priority = $Priority;
    }
}
