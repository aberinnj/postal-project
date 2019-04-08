<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeRegistrationForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('FName', TextType::class, ['label' => '* First Name ',  'required' => true])
        ->add('MInit', TextType::class, ['label' => '* Middle Initial ',  'required' => true])
        ->add('LName', TextType::class, ['label' => '* Last Name ',  'required' => true])
        ->add('Password', PasswordType::class, ['label' => '* Password ',  'required' => true])
        ->add('Submit', SubmitType::class, ['label' => 'Submit']);
    }
}