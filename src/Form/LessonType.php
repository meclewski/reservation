<?php

namespace App\Form;

use App\Entity\Lesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $lesson = $event->getData();
            $form = $event->getForm();

            if ($lesson->getChild1() == null) {
            $form->add('child_1', TextType::class, ['label' => 'Imię i nazwisko ucznia','required' => false,]); }
            if ($lesson->getChild2() == null) {
            $form->add('child_2', TextType::class, ['label' => 'Imię i nazwisko ucznia','required' => false,]); }
            if ($lesson->getChild3() == null) {
            $form->add('child_3', TextType::class, ['label' => 'Imię i nazwisko ucznia','required' => false,]); }
            if ($lesson->getChild4() == null) {
            $form->add('child_4', TextType::class, ['label' => 'Imię i nazwisko ucznia','required' => false,]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
