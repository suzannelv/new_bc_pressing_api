<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ZipCode;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ]) 
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('birthday', DateType::class, [
                'required'=>false,
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('password',PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Tél',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('profilUrl', FileType::class, [
                'required' => false,
                'mapped'=>false,
                'constraints'=>[
                    new Image([
                        'maxSize'=>'5000k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, GIF, SVG).',
                    ],
                    )
                ],
                'label'=>'Télécharger votre photo',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'class'=>'block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50'
                ]

            ]) 
            ->add('adress', TextType::class, [
                'label'=>'Adresse',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                ]
            ])
            ->add('zipCode', EntityType::class, [
                'class' => ZipCode::class,
                'choice_label' => 'zipCode',
                'label'=>'Code postale',
                'label_attr'=> [
                    'class' => 'block mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'class'=>'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'s\'inscrire',
                'attr'=>[
                    'class'=>'w-full text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-6'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false
        ]);
    }
}
