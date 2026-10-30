<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\DBAL\Types\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('celcius', null, [
                'attr' => ['placeholder' => 'Enter temperature in Celsius'],
                'attr' => ['min' => -40, 'max' => 50],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
