<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Enum\OrderStatusEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => OrderStatusEnum::PENDING,
                    'Completed' => OrderStatusEnum::PAID,
                    'Cancelled' => OrderStatusEnum::REJECTED,
                ],
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('task', EntityType::class, [
                'class' => Task::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('offer', EntityType::class, [
                'class' => Offer::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
