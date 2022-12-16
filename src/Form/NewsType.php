<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('newsTitle', TextType::class, [
                'attr' => ['class' => 'form-control new-title-form'],
                'label' => "Titre de l'actualité",
            ])

            ->add('newsContent', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-form '],
                'label' => "Contenu de l'actualité",
            ])

            ->add('newsIllustration', FileType::class, [
                'attr' => ['class' => 'file-form-control', 'accept' => 'image/*', 'onchange' => 'showPreview(event);'  ],
                'label' => 'Logo de votre team : ',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submit-news-form'],
                'label' => 'Envoyer',
                ]) 
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
