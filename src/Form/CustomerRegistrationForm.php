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

class CustomerRegistrationForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('Email', TextType::class, ['label' => '* Email ',  'required' => true])
        ->add('Password', PasswordType::class, ['label' => '* Password ',  'required' => true])
        ->add('FName', TextType::class, ['label' => '* First Name ',  'required' => true])
        ->add('MInit', TextType::class, ['label' => '* Middle Initial ',  'required' => true])
        ->add('LName', TextType::class, ['label' => '* Last Name ',  'required' => true])
        ->add('Street', TextType::class, ['label' => '* Street Address ',  'required' => true])
        ->add('ApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false])
        ->add('City', TextType::class, ['label' => '* City ',  'required' => true])
        ->add('State', ChoiceType::class, ['label'=> '* State ','choices' => [
            'Alabama'=>'AL',
            'Alaska'=>'AK',
            'Arizona'=>'AZ',
            'Arkansas'=>'AR',
            'California'=>'CA',
            'Colorado'=>'CO',
            'Connecticut'=>'CT',
            'Delaware'=>'DE',
            'Florida'=>'FL',
            'Georgia'=>'GA',
            'Hawaii'=>'HI',
            'Idaho'=>'ID',
            'Illinois'=>'IL',
            'Indiana'=>'IN',
            'Iowa'=>'IA',
            'Kansas'=>'KS',
            'Kentucky'=>'KY',
            'Louisiana'=>'LA',
            'Maine'=>'ME',
            'Maryland'=>'MD',
            'Massachusetts'=>'MA',
            'Michigan'=>'MI',
            'Minnesota'=>'MN',
            'Mississippi'=>'MS',
            'Missouri'=>'MO',
            'Montana'=>'MT',
            'Nebraska'=>'NE',
            'Nevada'=>'NV',
            'New Hampshire'=>'NH',
            'New Jersey'=>'NJ',
            'New Mexico'=>'NM',
            'New York'=>'NY',
            'North Carolina'=>'NC',
            'North Dakota'=>'ND',
            'Ohio'=>'OH',
            'Oklahoma'=>'OK',
            'Oregon'=>'OR',
            'Pennsylvania'=>'PA',
            'Rhode Island'=>'RI',
            'South Carolina'=>'SC',
            'South Dakota'=>'SD',
            'Tennessee'=>'TN',
            'Texas'=>'TX',
            'Utah'=>'UT',
            'Vermont'=>'VT',
            'Virginia'=>'VA',
            'Washington'=>'WA',
            'West Virginia'=>'WV',
            'Wisconsin'=>'WI',
            'Wyoming'=>'WY'
        ],  'required' => true])
        ->add('ZIP', NumberType::class, ['label' => '* ZIP Code ',  'required' => true])
        ->add('Submit', SubmitType::class, ['label' => 'Submit']);
    }
}