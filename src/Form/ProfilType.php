<?php

namespace App\Form;

use App\Form\UserType;
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

class ProfilType extends UserType
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
    }
    public function getParent()
    {
        return UserType::class;
    }
}
