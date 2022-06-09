<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'label' => 'Photo du Trick'])
            ->add('video', TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Video du Trick']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
