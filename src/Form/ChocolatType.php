<?php

namespace App\Form;

use App\Entity\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChocolatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom du chocolat :',
            'attr' => [
                'class' => 'form-control',
                'required' => true,
                'placeholder' => 'Entrez le nom du chocolat'
            ]
        ])
        ->add('titre', TextType::class, [
            'label' => 'Titre pour le chocolat :',
            'attr' => [
                'class' => 'form-select',
                'required' => true
            ]
        ])
        ->add('description', TextType::class, [
            'label' => 'Description du chocolat :',
            'attr' => [
                'class' => 'form-select',
                'required' => true
            ]
        ])
        ->add('isBest', CheckboxType::class, [
            'label' => 'Afficher dans la liste des meilleurs (oui/non) :',
            'attr' => [
                'class' => 'form-select',
                
            ]
        ])
        ->add('prix', TextType::class, [
            'label' => 'Prix :',
            'attr' => [
                'class' => 'form-control',
                'required' => true,
                'placeholder' => 'Entrez le prix du chocolat'
            ]
        ])
        ->add('image', FileType::class, [
            'label' => 'Image :',
            'required' => false,
            'attr' => [
                'class' => 'form-control',
                'accept' => 'image/*',
                'onchange' => 'previewImage(event)'
            ]
        ])
        ->remove('slug')
        ->remove('imageName')
        ->add('categorie', EntityType::class,[
            "class"=> Collection::class,
            "label"=>"Catégorie :"])
    ;
        }
    
}
