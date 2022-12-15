<?php

namespace App\Form;

use DateTime;
use App\Entity\Server;
use App\Entity\Tournament;
use App\Entity\TournamentMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TournamentType extends AbstractType
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

            ->add('tournamentName', TextType::class, [
                'attr' => ['class' => 'form-control form-tournament'],
                'label' => 'Nom du tournois',
            ])

            ->add('imgTournament', FileType::class, [
                'attr' => ['class' => 'file-form-control', 'accept' => 'image/*', 'onchange' => 'showPreview(event);'  ],
                'label' => 'Logo de votre tournois : ',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                ])

            ->add('startDate', DateTimeType::class, [
                'label' => 'Date de début',
                'attr'  => ['class' => 'form-control form-tournament','min' => ( new DateTime() )->format('Y-m-d H:i')],
                'widget' => 'single_text'
            ])

            ->add('endDate', DateTimeType::class, [
                'label' => 'Date de fin',
                'attr' => ['class' => 'form-control form-tournament', 'min' => ( new \DateTime() )->format('Y-m-d H:i'), 'max' => ( new \dateTime("2100-01-01 00:00"))->format('Y-m-d H:i') ],
                'widget' => 'single_text'
            ])

            ->add('mode', EntityType::class, [
                'label' => 'Mode de jeu',
                'class' => TournamentMode::class,
                'choice_label' => 'modeName',
                'attr' => ['class' => 'form-select form-tournament']
            ])

            ->add('descriptionTournament', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-form form-tournament'],
                'label' => 'Description du tournois',
            ])

            ->add('place', TextType::class, [
                'attr' => ['class' => 'form-control form-tournament'],
                'label' => 'Lieu',
            ])

            ->add('limitedInscription', ChoiceType::class, [
                'attr' => ['class' => 'form-tournament btwn2Choice'],
                'label' => "Nombre d'inscription limité ?",
                'choices' => [ 'Oui' => true, 'Non' => false],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])

            ->add('nbTeamLimit', IntegerType::class, [
                'attr' => ['class' => 'form-control form-tournament', 'min' => 2],
                'label' => "Nombre d'équipe participante MAX ?" 

            ])

            ->add('rewardChoice', ChoiceType::class, [
                'attr' => ['class' => 'form-tournament btwn2Choice'],
                'label' => 'Récompenses à la clef ?  :',
                'choices' => [ 'Oui' => true, 'Non (tournois amical)' => false],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])


            ->add('reward', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-form form-tournament '],
                'label' => 'Quels sont les récompenses ? ',
            ])


            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submitAddTournament'],
                'label' => 'Créer',
                ])

           
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class,
        ]);
    }
}
