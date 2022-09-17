<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('video', TextType::class , [
            'attr' => [
                'class' => 'form-control',
                'placeholder'=> "Récupérez l'url de partage de la vidéo "
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
