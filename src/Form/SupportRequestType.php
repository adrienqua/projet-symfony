<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SupportRequestType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('requestType', ChoiceType::class, [
            'label' => 'Type de support',
            'choices' => [
                'Choisissez un type de demande' => '',
                'Problème technique' => 'technical',
                'Demande de facturation' => 'billing',
                'Autre demande' => 'general'
            ],
            'placeholder' => false,
            'required' => true,
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre email',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email()
            ],
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
        ]);

    $data = $builder->getData();
    $requestType = $data['requestType'] ?? null;

    if ($requestType === 'technical') {
        $builder
            ->add('technicalDetails', TextareaType::class, [
                'label' => 'Description technique',
                'required' => true,
                'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
            ])
            ->add('attachments', FileType::class, [
                'label' => 'Pièces jointes',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
            ]);
    } elseif ($requestType === 'billing') {
        $builder->add('billingDetails', TextareaType::class, [
            'label' => 'Détails de la facturation',
            'required' => true,
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
        ]);
    } elseif ($requestType === 'general') {
        $builder->add('generalDetails', TextareaType::class, [
            'label' => 'Votre message',
            'required' => true,
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-lg p-2 mb-4 bg-gray-100 dark:bg-gray-800']
        ]);
    }
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'allow_extra_fields' => true
        ]);
    }
}