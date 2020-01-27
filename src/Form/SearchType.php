<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Department;
use App\Entity\Duty;
use App\Repository\CategoryRepository;
use App\Repository\DepartmentRepository;
use App\Repository\DutyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => 'codeName',
                'choice_value' => 'code',
                'required' => false,
                'label' => false,
                'placeholder' => 'Département',
                'query_builder' => function (DepartmentRepository $departmentRepository) {
                    return $departmentRepository->createQueryBuilder('d')
                        ->orderBy('d.code', 'ASC');
                },
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'description',
                'choice_value' => 'description',
                'required' => false,
                'label' => false,
                'placeholder' => 'Tous nos univers',
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    return $categoryRepository->createQueryBuilder('c')
                        ->orderBy('c.description', 'ASC');
                },
            ])
            ->add('duty', EntityType::class, [
                'class' => Duty::class,
                'choice_label' => 'name',
                'choice_value' => 'name',
                'required' => false,
                'label' => false,
                'placeholder' => 'Statut',
                'query_builder' => function (DutyRepository $dutyRepository) {
                    return $dutyRepository->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
