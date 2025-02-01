<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('username', null, ['label' => 'Nom d\'utilisateur'])
                ->add('email', null, ['label' => 'Email'])
                ->add('lastName', null, ['label' => 'Nom de famille'])
                ->add('firstName', null, ['label' => 'Prénom'])
                ->add('birthDate', null, ['label' => 'Date de naissance'])
                ->add('gender', null, ['label' => 'Genre']);
        }
    
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => User::class,
            ]);
        }
}
