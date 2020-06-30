<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BooleanType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipeName', TextType::class)
            ->add('personNum', NumberType::class)
            ->add('recipeRate', NumberType::class)
            ->add('categories', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'categoryName',
                'expanded' => true,
                'multiple' => true,
                
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
