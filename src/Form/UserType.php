<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Duty;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

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
            ->add('rolesLMCO', ChoiceType::class, [
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
            ->add('categories', EntityType::class, [
                'label' => 'Univers',
                'class' => Category::class,
                'choice_label' => 'description',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('urlFacebook', TextType::class, [
                'label' => 'Compte Facebook',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez entrer le même mot de passe.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
