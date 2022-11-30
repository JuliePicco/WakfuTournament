<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [ 
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe']),

                    new Regex([
                        'pattern' => "/^\S*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S*[\W])[a-zA-Z\d]{12,}\S*$/",
                        'message' => 'Minimum 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial',
                    ]),

                    new Length([
                        'maxMessage' => 'Votre mot de passe doit comporter au maximum {{ limit }} caractères',
                        'max' => 64,
                    ]),
                ],
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
