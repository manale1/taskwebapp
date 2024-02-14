<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephone',TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('email',EmailType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}