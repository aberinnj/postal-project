<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeLoginForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('EmployeeID', TextType::class, [ 'label' => 'EmployeeID' ])
            ->add('Password', PasswordType::class, ['label' => 'Password' ])
            ->add('Submit', SubmitType::class, [ 'label' => 'Login'] );
    }
}