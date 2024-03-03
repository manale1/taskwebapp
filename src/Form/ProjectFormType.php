<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Name'
                ]
           )
            ->add('datedebut',DateType::class,[
                'attr' => ['class' => 'form-control','type' => 'date'],
                'label' => 'Start date'
            ])
            ->add('datefin',DateType::class,[
                'attr' => ['class' => 'form-control','type' => 'date'],
                'label' => 'End date'
            ])
            ->add('organisateur',EntityType::class,[
                'attr' => ['class' => 'form-control'],
                'class' => 'App\Entity\Employe',
                'label' => 'Organizer',
                'choice_label' => function($employe)
                {
                    return $employe->getNom().' '.$employe->getPrenom();
                }
            ])
            ->add('nb_inscription',TextType::class,[
                'label' => 'Maximum number of participants'
            ])
            ->add('infos_project',TextareaType::class,[
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Description'

                ]
            )
            ->add('etat',EntityType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'class' => 'App\Entity\Etat',
                    'label' => 'State',
                    'choice_label' => function($etat)
                    {
                        return $etat->getLibelle();
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
