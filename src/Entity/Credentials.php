<?php

namespace App\Entity;

class Credentials
{
    protected $Password;
    protected $EmployeeID;
    protected $Email;

    // Password
    public function getPassword()
    {
        return $this->Password;
    }

    public function setPassword($Password){
        $this->Password = md5($Password);
    }


    // EmployeeID
    public function getEmployeeID()
    {
        return $this->EmployeeID;
    }

    public function setEmployeeID($EmployeeID = null){
        $this->EmployeeID = $EmployeeID;
    }


    // Email
    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($Email = null){
        $this->Email = $Email;
    }

}
