<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'trim' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'trim' => true,
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '256k',
                        'maxSizeMessage' => 'La taille de l\'image ne doit pas dépasser 256ko',
                        'mimeTypes' => ["image/jpeg", "image/png", "image/webp", "image/gif"],
                        'mimeTypesMessage' => 'Format d\'image non valide',
                    ])
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'trim' => true,
            ])
            ->add('county', TextType::class, [
                'label' => 'Département',
                'trim' => true,
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
                'trim' => true,
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Rôle',
                'trim' => true,
                'choices' => User::ROLES,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Biographie',
                'trim' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
