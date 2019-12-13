<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Duty;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
            ])
            ->add('picture', TextType::class, [
                'label' => 'Photo',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('department', EntityType::class, [
                'label' => 'Département',
                'class' => Department::class,
                'choice_label' => 'codeName',
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => User::ROLES,
                'expanded' => true,
            ])
            ->add('duties', EntityType::class, [
                'label' => 'Préférences',
                'class' => Duty::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Biographie',
            ])
            ->add('urlFacebook', TextType::class, [
                'label' => 'Compte Facebook',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
