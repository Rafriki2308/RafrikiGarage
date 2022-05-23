<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nombre'
            ])
            ->add('surnames', null, [
                'label' => 'Apellidos'
            ])
            ->add('idCard', null, [
                'label' => 'Número Identificación'
            ])
            ->add('telNumber', null, [
                'label' => 'Número Teléfono'
            ])
            ->add('eMail', null, [
                'label' => 'Email'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
