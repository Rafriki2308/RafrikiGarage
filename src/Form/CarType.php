<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('regPlate', null, [
                'label' => 'Matrícula'
            ])
            ->add('chasisNum', null, [
                'label' => 'Número Chasis'
            ])
            ->add('brand', null,[
                'label' => 'Marca'
            ])
            ->add('model', null, [
                'label' => 'Modelo'
            ])
            ->add('engineType', null, [
                'label' => 'Tipo Motor'
            ])
            ->add('pictureCar', FileType::class, [
                'label'=>'Ruta Foto',
                'data_class' => null
            ])
            ->add('isActive', null,[
                'label' =>'Esta en taller'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
