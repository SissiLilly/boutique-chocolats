<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Transporteur;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
   {

    $user = $options['user'];

    $builder
        ->add('adresse', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Adress::class,
            'choices' => $user->getAdresses(),
            'multiple' => false,
            'expanded' => false, 
            'attr' => [
                'class' => 'form-control' 
            ]
        ])
        ->add('transporteur', EntityType::class, [
            'label' => 'Choisissez votre transporteur',
            'required' => true,
            'class' => Transporteur::class,
            'multiple' => false,
            'expanded' => false, 
            'attr' => [
                'class' => 'form-control' 
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Valider ma commande',
            'attr' => [
                'class' => 'btn btn-success btn-block'
            ]
        ])
    ;
    
            }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }

}
