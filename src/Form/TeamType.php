<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Server;
use App\Form\MembersType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('server', EntityType::class, [
                'label' => 'Serveur',
                'class' => Server::class,
                'choice_label' => 'serverName',
                'attr' => ['class' => 'form-select form-tournament']
                ])

            ->add('teamName', TextType::class, [
                'attr' => ['class' => 'form-control form-tournament'],
                'label' => 'Nom de la team',
            ])

            ->add('teamLogo', FileType::class, [
                'attr' => ['class' => 'file-form-control', 'accept' => 'image/*', 'onchange' => 'showPreview(event);'  ],
                'label' => 'Logo de votre team : ',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                ])

            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-form form-tournament'],
                'label' => 'Description de votre team',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submitAddTournament'],
                'label' => 'Enregistrer',
                ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
