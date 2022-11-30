<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
                ])

            ->add('pseudonyme', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les conditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre !',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe'],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

// Idea for regex
// (?=.*\d) Atleast a digit
// (?=.*[a-z]) Atleast a lower case letter
// (?=.*[A-Z]) Atleast an upper case letter
// (?!.* ) no space
// (?=\S*[\W]) no words
// (?=.*[^a-zA-Z0-9]) at least a character except a-zA-Z0-9
// .{8,16} between 8 to 16 characters
// \s* any number of whitespace characters
