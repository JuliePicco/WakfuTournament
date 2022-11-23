<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // ->add('email', EmailType::class, [
            //     'attr' => ['class' => 'form-control']
            // ])

            ->add('actualPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])

            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre !',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-edit btn-margin'],
                'label' => 'Modifier',
                ])
          
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
