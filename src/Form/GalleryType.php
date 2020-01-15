<?php

namespace App\Form;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoFile', VichImageType::class, [
                'label'             => 'Photo',
                'download_link'     => false,
                'allow_delete'      => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}
