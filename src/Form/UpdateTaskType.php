<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => 'Designation'
            ])
            ->add('id_client',EntityType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'class' => 'App\Entity\Client',
                    'label' => 'Name of client',
                    'choice_label' => function($client)
                    {
                        return $client->getNom().' '. $client->getPrenom();
                    },
                ])
            ->add('id_outil',EntityType::class,
            [
                'attr' => ['class' => 'form-control'],
                'class' => 'App\Entity\Outil',
                'label' => 'Name of tool',
                'choice_label' => function($outil)
                {
                    return $outil->getNom();
                },
            ])
            ->add('id_employe',EntityType::class,[
                'attr' => ['class' => 'form-control'],
                'class' => 'App\Entity\Employe',
                'label' => 'Name of employee',
                'choice_label' => function($employe)
                {
                    return $employe->getNom().' '. $employe->getPrenom();
                },
            ])
            ->add('id_statut',EntityType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'class' => 'App\Entity\Statut',
                    'label' => 'State',
                    'choice_label' => function($statut)
                    {
                        return $statut->getLibelle();
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
