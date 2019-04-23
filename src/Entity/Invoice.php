<?php
namespace App\Entity;

class Invoice
{
    protected $InvoiceID;

    public function getInvoiceID()
    {
        return $this->InvoiceID;
    }

    public function setInvoiceID($InvoiceID)
    {
        $this->InvoiceID = $InvoiceID;
    }
}
