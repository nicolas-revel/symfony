<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Votre Email',
                    ]
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label' => false,
                    'mapped' => false,
                    'attr' => [
                        'placeholder' => 'Votre mot de passe',
                        'autocomplete' => 'new-password'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci d\'entrer un mot de passe',
                        ]),
                    ],
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Votre pseudo',
                    ],
                ]
            )
            ->add(
                'birthdate',
                DateType::class,
                [
                    'label' =>  'Votre date de naissance : ',
                ]
            )
            ->add(
                'Inscription',
                SubmitType::class,
                [
                    'label' => 'S\'inscrire',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
