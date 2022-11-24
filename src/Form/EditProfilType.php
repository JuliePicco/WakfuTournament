<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
                ])
                
            ->add('pseudonyme', TextType::class, [
                'label' => 'Pseudo',
                'attr' => ['class' => 'form-control']
                ])

            ->add('avatar', FileType::class, [
                'attr' => ['class' => 'file-form-control', 'accept' => 'image/*', 'onchange' => 'showPreview(event);'  ],
                'label' => 'Avatar : ',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                ])

            ->add('discordPseudo', TextType::class, [
                'label' => 'Pseudo discord',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                ])
                
            ->add('twitchLink', TextType::class, [
                'label' => 'Chaîne Twitch',
                'attr' => ['class' => 'form-control'],
                'required' => false,
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
