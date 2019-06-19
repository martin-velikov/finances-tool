<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your password.'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Password must be at least {{ limit }} characters long.',
                        'max' => 4096,
                        'maxMessage' => 'Password cannot be longer than {{ limit }} characters.',
                    ])
                ],
                'invalid_message' => 'The password fields must match.',
                'first_options'  => [
                    'label_format' => 'Enter your password',
                ],
                'second_options' => [
                    'label_format' => 'Repeat your password',
                ],
            ])
            ->add('name')
            ->add('email', EmailType::class)
            ->add('phone', TelType::class, [
                'required' => false,
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue(),
            ])
        ;
    }
}
