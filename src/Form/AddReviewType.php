<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Review;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', null, [
            'label' => 'Ajouter une évaluation',
            'label_attr' => ['class' => 'text-xl font-bold mb-2'],
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-3xl p-8 mt-4 mb-4 bg-gray-100 dark:bg-gray-700 min-h-24', 'rows' => 5],
            ])
            ->add('rating', ChoiceType::class, [
            'label' => false,
            'choices' => [
                '5 Étoiles' => 5,
                '4 Étoiles' => 4,
                '3 Étoiles' => 3,
                '2 Étoiles' => 2,
                '1 Étoile' => 1,
            ],
            'attr' => ['class' => 'form-input mt-1 block w-full rounded-3xl px-8 py-4 mb-4 bg-gray-100 dark:bg-gray-700'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
