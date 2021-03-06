<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name Surname :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name Surname',
                    'autocomplete' => 'new-password'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('mobilePhone', TextType::class, [
                'label' => 'Mobile Phone :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Mobile Phone',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('reservationDate', DateType::class, [
                'label' => 'Reservation Date :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime('now')
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                    'autocomplete' => 'off'
                ]
            ])->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
