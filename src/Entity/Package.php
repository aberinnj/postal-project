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

    protected $rStreet;
    protected $rApartmentNo;
    protected $rCity;
    protected $rState;
    protected $rZIP;

    protected $Street;
    protected $ApartmentNo;
    protected $City;
    protected $State;
    protected $ZIP;

    protected $isFragile;
    protected $Service;
    protected $SendDate;
    protected $Status;
    protected $useDefaultAddress;
    protected $Total;

    function __construct() {
        $this->SendDate = new \DateTime();   
        $this->Status = 1;
    }

    // Email
    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($Email){
        $this->Email = $Email;
    }

    // Total
    public function getTotal()
    {
        return $this->Total;
    }

    public function setTotal($Total){
        $this->Total = $Total;
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


    // rState
    public function getrState()
    {
        return $this->rState;
    }

    public function setrState($rState){
        $this->rState = $rState;
    }

    // rCity
    public function getrCity()
    {
        return $this->rCity;
    }

    public function setrCity($rCity){
        $this->rCity = $rCity;
    }

    // rZIP
    public function getrZIP()
    {
        return $this->rZIP;
    }

    public function setrZIP($rZIP){
        $this->rZIP = $rZIP;
    }

    // rStreet
    public function getrStreet()
    {
        return $this->rStreet;
    }

    public function setrStreet($rStreet){
        $this->rStreet = $rStreet;
    }

    // rApartmentNo
    public function getrApartmentNo()
    {
        return $this->rApartmentNo;
    }

    public function setrApartmentNo($rApartmentNo = null){
        $this->rApartmentNo = $rApartmentNo;
    }


    // isFragile
    public function getIsFragile()
    {
        return $this->isFragile;
    }

    public function setIsFragile($isFragile){
        $this->isFragile = $isFragile;
    }

    // Service
    public function getService()
    {
        return $this->Service;
    }
    
    public function setService($Service){
        $this->Service = $Service;
    }

    // Status
    public function getStatus()
    {
        return $this->Status;
    }
    
    public function setStatus($Status){
        $this->Status = 1;
    }


    // SendDate
    public function getSendDate()
    {
        return $this->SendDate;
    }
    
    public function setSendDate($SendDate){
        $this->SendDate = $SendDate;
    }

    // default Address
    public function getuseDefaultAddress()
    {
        return $this->useDefaultAddress;
    }
    
    public function setuseDefaultAddress($useDefaultAddress){
        $this->useDefaultAddress = $useDefaultAddress;
    }
}
