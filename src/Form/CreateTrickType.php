<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreateTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',  TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom'])
            ->add('description', textType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description'])
            ->add('type', textType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Type de Trick'])
            ->add('photo', FileType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Photo du Trick',
                'mapped'=>false,
                'required'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Seuls les formats jpg et png sont authorisés',
                    ])
                ]
                ])
            ->add('video', TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Lien vers la video du Trick']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
