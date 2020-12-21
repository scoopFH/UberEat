<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delivery_date', DateType::class)
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'in preparation' => 'in preparation',
                    'delivered' => 'delivered',
                    'in delivering' => 'in delivering',
                ],
            ])
            ->add('restaurant', EntityType::class, [
                'class' => Restaurant::class,
                'choice_label' => 'name',
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
