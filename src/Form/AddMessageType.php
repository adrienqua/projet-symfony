<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
            'label' => false,
            'label_attr' => ['class' => 'text-lg font-medium mb-2'],
            'attr' => [
                'class' => 'form-input mt-1 block w-full shadow-sm rounded-3xl p-2 mb-4 bg-white min-h-24 dark:bg-gray-700 dark:text-white',
                'rows' => 4,
            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
