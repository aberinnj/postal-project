<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InvoiceForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('InvoiceID', TextType::class, ['label' => false,  'required' => true, 'attr'=>['placeholder'=>'Enter Your InvoiceID']])
        ->add('Submit', SubmitType::class, ['label' => 'Submit']);
    }
}