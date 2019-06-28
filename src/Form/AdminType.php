<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('childName', TextType::class, ['label' => 'Imię ucznia', 'attr' => ['readonly' => true]])
            ->add('parentName', TextType::class, ['label' => 'Imię i nazwisko rodzica', 'attr' => ['readonly' => true]])
            ->add('parentEmail', TextType::class, ['label' => 'Adres e-mail', 'attr' => ['readonly' => true]])
            ->add('parentPhone', TextType::class, ['label' => 'Nr telefonu', 'attr' => ['readonly' => true]])
            ->add('confirmed', CheckboxType::class, ['label' => 'Potwierdzone', 'attr' => ['readonly' => true]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
