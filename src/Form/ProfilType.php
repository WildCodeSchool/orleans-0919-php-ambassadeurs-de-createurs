<?php

namespace App\Form;

use App\Form\UserInscriptionType;
use App\Entity\Department;
use App\Entity\Duty;
use App\Entity\User;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\DepartmentRepository;
use App\Repository\DutyRepository;
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
use Vich\UploaderBundle\Form\Type\VichImageType;

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
        $builder->add('pictureFile', VichImageType::class, [
            'label'             => 'Photo',
            'download_link'     => false,
            'allow_delete'      => false,
        ]);
        $builder->add('department', EntityType::class, [
            'label' => 'Département',
            'class' => Department::class,
            'choice_label' => 'codeName',
            'query_builder' => function (DepartmentRepository $departmentRepository) {
                return $departmentRepository->createQueryBuilder('d')
                    ->orderBy('d.code', 'ASC');
            },
        ]);
        $builder->add('duties', EntityType::class, [
            'label' => 'Préférences',
            'class' => Duty::class,
            'choice_label' => 'name',
            'expanded' => true,
            'multiple' => true,
            'query_builder' => function (DutyRepository $dutyRepository) {
                return $dutyRepository->createQueryBuilder('d')
                    ->orderBy('d.name', 'ASC');
            },
        ]);
        $builder->add('categories', EntityType::class, [
            'label' => 'Univers',
            'class' => Category::class,
            'choice_label' => 'description',
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
            'query_builder' => function (CategoryRepository $categoryRepository) {
                return $categoryRepository->createQueryBuilder('c')
                    ->orderBy('c.description', 'ASC');
            },
        ]);
    }

    public function getParent()
    {
        return UserInscriptionType::class;
    }
}
