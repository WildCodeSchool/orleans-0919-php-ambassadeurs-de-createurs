<?php

namespace App\Form;

use App\Form\UserInscriptionType;
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

class ProfilType extends UserInscriptionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('password');
        $builder->remove('role');
        $builder->add('description', TextareaType::class, [
            'label' => 'Biographie',
            'required' => false,
        ]);
        $builder->add('urlFacebook', TextType::class, [
            'label' => 'Compte Facebook',
            'required' => false,
        ]);
        $builder->add('picture', TextType::class, [
            'label' => 'Photo',
            'required' => false,
        ]);
        $builder->add('department', EntityType::class, [
            'label' => 'Département',
            'class' => Department::class,
            'choice_label' => 'codeName',
        ]);
        $builder->add('duties', EntityType::class, [
            'label' => 'Préférences',
            'class' => Duty::class,
            'choice_label' => 'name',
            'expanded' => true,
            'multiple' => true,
        ]);
        $builder->add('categories', EntityType::class, [
            'label' => 'Univers',
            'class' => Category::class,
            'choice_label' => 'description',
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
        ]);
    }

    public function getParent()
    {
        return UserInscriptionType::class;
    }
}
