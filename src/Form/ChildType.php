<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('childName', TextType::class, ['label' => 'Imię ucznia'])
            ->add('parentName', TextType::class, ['label' => 'Imię i nazwisko rodzica'])
            ->add('parentEmail', TextType::class, ['label' => 'Adres e-mail'])
            ->add('parentPhone', TextType::class, ['label' => 'Nr telefonu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
