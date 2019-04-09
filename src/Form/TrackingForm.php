<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TrackingForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('PackageID', TextType::class, ['label' => false,  'required' => true, 'attr'=>['placeholder'=>'Tracking ID']])
        ->add('Submit', SubmitType::class, ['label' => 'Submit']);
    }
}