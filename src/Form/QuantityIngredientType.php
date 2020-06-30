<?php

namespace App\Form;

use App\Entity\Unit;
use App\Entity\Quantity;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QuantityIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('ingredient', EntityType::class, array(
                'class' => Ingredient::class,
                'choice_label' => 'ingredientName',
                'expanded' => true,
            ))
            ->add('unit', EntityType::class, array(
                'class' => Unit::class,
                'choice_label' => 'unit',
                'expanded' => true,
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quantity::class,
        ]);
    }
}
