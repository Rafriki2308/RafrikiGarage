<?php

namespace App\Form;

use App\Entity\Worksheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorksheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isActive', null,[
                'label' =>'Esta en taller'
            ])
            ->add('description', null, [
                'label' => 'Descripción'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worksheet::class,
        ]);
    }
}
