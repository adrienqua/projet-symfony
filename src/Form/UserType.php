<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('lastName')
            ->add('firstName')
            ->add('birthDate', null, [
                'widget' => 'single_text',
            ])
            ->add('gender')
            ->add('email')
            ->add('password')
            ->add('roles')
            ->add('offersAdultContent')
            ->add('isVerified')
            ->add('favoriteTasks', EntityType::class, [
                'class' => Task::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
