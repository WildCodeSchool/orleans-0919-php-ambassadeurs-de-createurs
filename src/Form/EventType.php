<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Event;
use App\Repository\BrandRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DateTime;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', TextType::class, [
                'label' => 'Localisation',
                'trim' => true,
            ])
            ->add('dateTime', DateTimeType::class, [
                'label' => 'Date',
                'format' => 'Y-m-d H:i:s',
                'data' => new DateTime(),
            ])
            ->add('description', TextareaType::class, ['label' => 'Description', 'trim' => true,])
            ->add('brand', EntityType::class, [
                'label' => 'Marque',
                'class' => Brand::class,
                'choice_label' => 'name',
                'query_builder' => function (BrandRepository $brandRepository) {
                    return $brandRepository->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
