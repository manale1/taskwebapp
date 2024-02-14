<?php

namespace App\Form;

use App\Entity\Employe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom',TextType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('email',EmailType::class,[
                'attr' => ['class' => 'form-control']]
            )
            ->add('dateNaiss',DateType::class,[
                'attr' => ['class' => 'form-control','type' => 'date'],
                'years' => range(date('Y') -70, date('Y')),
            ])
            ->add('telephone',TelType::class,[
                'attr' => ['class' => 'form-control']]

            )
            ->add('adresse',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('poste',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','class' => 'form-control'],

                    'invalid_message' => 'Passwords don'.'t match',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Password','attr' => ['class' => 'form-control']],
                    'second_options' => ['label' => 'Confirmation','attr' => ['class' => 'form-control']]

                ])
            ->add('administrateur',CheckboxType::class,[
                'attr' => ['class' => 'form-check-label'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
