<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('city')
//            ->add('country')
//            ->add('latitude')
//            ->add('longitude')
//        ;
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Enter city name',
                ]

            ])
        ->add('country', ChoiceType::class, [
            'choices' => [
                'Poland' => 'PL',
                'United States' => 'US',
                'Germany' => 'DE',
                'France' => 'FR',
                'Spain' => 'ES',
                'Italy' => 'IT',
                'United Kingdom' => 'GB',
            ]
        ])
        ->add('latitude', NumberType::class, [
            'attr' => ['step' => 0.01, 'min' => -90.0, 'max' => 90.0, 'placeholder' => 'Enter latitude', 'precision' => 7],
        ])
        ->add('longitude', NumberType::class, [
            'attr' => ['step' => 0.01, 'min' => -180.0, 'max' => 180.0, 'placeholder' => 'Enter longitude', 'precision' => 7],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
