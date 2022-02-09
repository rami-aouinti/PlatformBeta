<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Title',
                'attr' => array(
                    'placeholder' => 'Title'
                )
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Firstname ',
                'attr' => array(
                    'placeholder' => 'Firstname'
                )
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Lastname ',
                'attr' => array(
                    'placeholder' => 'Lastname'
                )
            ))
            ->add('birthday', DateType::class, array(
                'attr' => array(
                    'data-target' => "#reservationdate"
                )
            ))
            ->add('nationality', CountryType::class, [
                'placeholder' => 'Nationality',
            ])
            ->add('email', TextType::class, array(
                'label' => 'Email ',
                'attr' => array(
                    'placeholder' => 'Email'
                )
            ))
            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('telefone', NumberType::class, array(
                'label' => 'Tel ',
                'attr' => array(
                    'placeholder' => 'Tel'
                )
            ))
            ->add('country', CountryType::class, [
                'placeholder' => 'Country',
            ])
            ->add('state', TextType::class, array(
                'label' => 'State ',
                'attr' => array(
                    'placeholder' => 'State'
                )
            ))
            ->add('postcode', NumberType::class, array(
                'label' => 'Postcode ',
                'attr' => array(
                    'placeholder' => 'Postcode'
                )
            ))
            ->add('street', TextType::class, array(
                'label' => 'Street ',
                'attr' => array(
                    'placeholder' => 'Street'
                )
            ))
            ->add('homenumber', TextType::class, array(
                'label' => 'Home Number',
                'attr' => array(
                    'placeholder' => 'Home Number'
                )
            ))
            ->add('active', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
