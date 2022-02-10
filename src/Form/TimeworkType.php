<?php

namespace App\Form;

use App\Entity\Timework;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Content',
                    'class' => 'form-control'
                )
            ))
            ->add('start', DateTimeType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Start',
                    'class' => 'form-control'
                )
            ))
            ->add('end', DateTimeType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'End',
                    'class' => 'form-control'
                )
            ))
            ->add('ticket')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Timework::class,
        ]);
    }
}
