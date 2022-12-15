<?php

namespace App\Form;

use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('topicName', TextType::class, [
                'attr' => ['class' => 'form-control form-tournament'],
                'label' => 'Titre de votre topic',
            ])

            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-form form-tournament'],
                'label' => 'Message',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submitAddTournament'],
                'label' => 'Envoyer',
                ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
