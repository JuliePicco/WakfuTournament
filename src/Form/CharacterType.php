<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\Nation;
use App\Entity\Server;
use App\Entity\Character;
use App\Entity\ClassCharacter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('server', EntityType::class, [
                'class' => Server::class,
                'label' => 'Serveur',
                'choice_label' => 'serverName',
                'attr' => ['class' => 'form-select']
            ])


            ->add('characterName', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Pseudo',
            ])


            ->add('classCharacter', EntityType::class, [
                'label' => 'Classe',
                'class' => ClassCharacter::class,
                'choice_label' => 'className',
                'attr' => ['class' => 'form-select']
            ])

            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'label' => 'Genre',
                'choice_label'=>'genderType',
                'attr' => ['class' => 'choiceGender btwn2Choice'],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                ])


             
            ->add('nation', EntityType::class, [
                'class' => Nation::class,
                'label' => 'Nation',
                'choice_label' => 'name',
                'attr' => ['class' => 'form-select']
            ])

            ->add('guild', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Guilde',
                'required' => false,
                ])


            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-submit btn-margin'],
                'label' => 'Enregistrer',
                ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
