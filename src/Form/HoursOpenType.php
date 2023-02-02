<?php

namespace App\Form;

use App\Entity\OpenHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoursOpenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tabHourStart = [];
        $hoursStart = 8;
        $hoursEnd = 18;
        for($i = $hoursStart; $i <= $hoursEnd; $i++){
            $tabHourStart[] = $i;
        }

        $builder
            ->add('start_hours', TimeType::class, [
                'hours' => $tabHourStart,
                'minutes' => [0, 10, 20, 30, 40, 50]
            ])
            ->add('end_hours', TimeType::class, [
                'hours' => $tabHourStart,
                'minutes' => [0, 10, 20, 30, 40, 50]
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpenHours::class,
        ]);
    }
}
