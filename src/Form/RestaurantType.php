<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('picture', TextType::class, [
                'label' => 'logo or picture url'
            ])
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('promotion', TextType::class, [
                'label' => 'promotion picture url',
                'required' => false,
            ])
            ->add('dishes', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
