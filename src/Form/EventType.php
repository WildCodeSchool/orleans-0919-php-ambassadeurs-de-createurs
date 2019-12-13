<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', TextType::class, ['label' => 'Localisation', 'trim' => true,])
            ->add('dateTime', DateTimeType::class, ['label' => 'Date' ,'format' => 'Y-m-d H:i:s'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'trim' => true,])
            ->add('user', null, ['label' => 'Utilisateur', 'choice_label' => 'firstname']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
