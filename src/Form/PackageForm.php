<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PackageForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){

        $states = [
            'Alabama'=>1,
            'Alaska'=>2,
            'Arizona'=>3,
            'Arkansas'=>4,
            'California'=>5,
            'Colorado'=>6,
            'Connecticut'=>7,
            'Delaware'=>8,
            'Florida'=>9,
            'Georgia'=>10,
            'Hawaii'=>11,
            'Idaho'=>12,
            'Illinois'=>13,
            'Indiana'=>14,
            'Iowa'=>15,
            'Kansas'=>16,
            'Kentucky'=>17,
            'Louisiana'=>18,
            'Maine'=>19,
            'Maryland'=>20,
            'Massachusetts'=>21,
            'Michigan'=>22,
            'Minnesota'=>23,
            'Mississippi'=>24,
            'Missouri'=>25,
            'Montana'=>26,
            'Nebraska'=>27,
            'Nevada'=>28,
            'New Hampshire'=>29,
            'New Jersey'=>30,
            'New Mexico'=>31,
            'New York'=>32,
            'North Carolina'=>33,
            'North Dakota'=>34,
            'Ohio'=>35,
            'Oklahoma'=>36,
            'Oregon'=>37,
            'Pennsylvania'=>38,
            'Rhode Island'=>39,
            'South Carolina'=>40,
            'South Dakota'=>41,
            'Tennessee'=>42,
            'Texas'=>43,
            'Utah'=>44,
            'Vermont'=>45,
            'Virginia'=>46,
            'Washington'=>47,
            'West Virginia'=>48,
            'Wisconsin'=>49,
            'Wyoming'=>50,
        ];

        $services = [
            'Ground Economy'=>1,
            'Priority Overnight'=>2,
            'Same-Day Delivery'=>3
        ];

        $builder
        ->add('Email', EmailType::class, ['label' => '* Email ',  'required' => true])
        ->add('Recipient', TextType::class, ['label' => '* Recipient Name ',  'required' => true])
        ->add('Weight', NumberType::class, ['label' => '* Weight ', 'required' => true])
        ->add('Length', NumberType::class, ['label' => '* Length ',  'required' => true])
        ->add('Width', NumberType::class, ['label' => '* Width ',  'required' => true])
        ->add('Height', NumberType::class, ['label' => '* Height ',  'required' => true])

        ->add('rStreet', TextType::class, ['label' => '* Street Address ', 'required' => true, 'attr'=>['class'=>'postal_returnAddress'] ])
        ->add('rApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false, 'attr'=>['class'=>'postal_returnAddress']])
        ->add('rCity', TextType::class, ['label' => '* City ',  'required' => true, 'attr'=>['class'=>'postal_returnAddress']])
        ->add('rState', ChoiceType::class, ['label'=> '* State ','choices' => $states,  'required' => true, 'attr'=>['class'=>'postal_returnAddress']])
        ->add('rZIP', NumberType::class, ['label' => '* ZIP Code ',  'required' => true, 'attr'=>['class'=>'postal_returnAddress']])

        ->add('Street', TextType::class, ['label' => '* Street Address ', 'required' => true])
        ->add('ApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false])
        ->add('City', TextType::class, ['label' => '* City ',  'required' => true])
        ->add('State', ChoiceType::class, ['label'=> '* State ','choices' => $states,  'required' => true])
        ->add('ZIP', NumberType::class, ['label' => '* ZIP Code ',  'required' => true])
        ->add('Service', ChoiceType::class, ['label' => '* Select Shipping Type ', 'choices' => $services,  'required' => true])
        ->add('SendDate', DateType::class, ['label' => '* Set Pickup/Drop-off date ', 'required' => true])
        ->add('isFragile', CheckboxType::class, ['label' => 'isFragile? ', 'required' => false])   
        ->add('Location', TextType::class, ['label' => '* Selected Office Location : ', 'required'=> true, 'attr'=>['readonly'=>true]]) 
        ->add('next', SubmitType::class, ['label' => 'Next'])
        ->add('continue', SubmitType::class, ['label' => 'Next'])
        ->add('submit', SubmitType::class, ['label' => 'Submit Payment and Order']);


    }
}