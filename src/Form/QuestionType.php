<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\QuestionCategory;
use App\Repository\QuestionCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextType::class, [
                'label' => 'Question',
            ])
            ->add('answer', TextType::class, [
                'label' => 'Réponse',
            ])
            ->add('category', EntityType::class, [
                'class' => QuestionCategory::class,
                'label' => 'Catégorie',
                'choice_label' => 'category',
                'query_builder' => function (QuestionCategoryRepository $questionCategoryRepository) {
                    return $questionCategoryRepository->createQueryBuilder('c')
                        ->orderBy('c.category', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
