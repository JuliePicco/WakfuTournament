<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subCategoryName', TextType::class, [
                'attr' => ['class' => 'form-control form-tournament'],
                'label' => 'Nom de la sous catégorie :',
            ]
            )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'categoryName',
                'attr' => ['class' => 'form-select']
            ])

            ->add('statut', ChoiceType::class, [
                'attr' => ['class' => 'form-tournament btwn2Choice'],
                'label' => "Sous catégorie réservé aux administrateurs ?",
                'choices' => [ 'Oui' => false, 'Non' => true],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
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
            'data_class' => SubCategory::class,
        ]);
    }
}
