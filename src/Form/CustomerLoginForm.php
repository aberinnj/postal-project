<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CustomerLoginForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('Email', EmailType::class, [ 'label' => false, 'attr' => ['placeholder' => 'Email']])
            ->add('Password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Password']])
            ->add('Submit', SubmitType::class, [ 'label' => 'Login'] );
    }
}