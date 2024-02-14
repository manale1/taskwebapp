<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Employe;
use App\Entity\Outil;
use App\Entity\Tache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_debut',DateType::class,['data' => new \DateTime(),
                'attr' => ['class' => 'form-control']])
            ->add('id_client',EntityType::class,[
                'attr' => ['class' => 'form-control'],
                'class' => 'App\Entity\Client',
                'choice_label' => function($client)
                {
                    return $client->getNom().' '. $client->getPrenom();
                },
            ])
            ->add('id_employe',EntityType::class,[
                'attr' => ['class' => 'form-control'],
                'class' => 'App\Entity\Employe',
                'choice_label' => function($employe)
                {
                    return $employe->getNom().' '. $employe->getPrenom();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
