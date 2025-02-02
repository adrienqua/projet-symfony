<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
            'label' => 'Email',
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
            ])
            ->add('username', null, [
            'label' => 'Nom d\'utilisateur',
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
            ])
            ->add('firstName', null, [
            'label' => 'Prénom',
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
            ])
            ->add('lastName', null, [
            'label' => 'Nom de famille',
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
            ])
            ->add('birthDate', DateType::class, [
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800'],
            'constraints' => [
                new NotBlank([
                'message' => 'Veuillez entrer votre date de naissance',
                ]),
            ],
            ])
            ->add('plainPassword', PasswordType::class, [
            'label' => 'Mot de passe',
            'mapped' => false,
            'attr' => [
                'autocomplete' => 'new-password',
                'class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800',
            ],
            'constraints' => [
                new NotBlank([
                'message' => 'Veuillez entrer un mot de passe',
                ]),
                new Length([
                'min' => 6,
                'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                'max' => 4096,
                ]),
            ],
            ])
/*             ->add('discr', null, [
            'data' => 'client',
            'attr' => ['style' => 'display:none;'],
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
