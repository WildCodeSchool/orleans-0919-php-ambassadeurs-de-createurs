<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description')
            ->add('site', UrlType::class, [
                'required' => false,
            ])
            ->add('instagram', UrlType::class, [
                'required' => false,
            ])
            ->add('host_advantage', TextType::class, [
                'label' => 'Avantages pour les hôtes',
                'required' => false,
            ])
            ->add('seller_advantage', TextType::class, [
                'label' => 'Avantages pour les vendeurs',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Brand::class,
        ]);
    }
}
