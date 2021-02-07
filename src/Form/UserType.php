<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
            ->add('password', PasswordType::class, [
                'label' => 'Password :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please do not blank!',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Please enter at least 6 characters!',
                        'max' => 4096,
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Customer' => 'ROLE_CUSTOMER',
                    'Authorised Person' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER'
                ],
                'label' => 'Role :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control',
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
            ->add('title', TextType::class, [
                'label' => 'User Definition :',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'User Definition',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
