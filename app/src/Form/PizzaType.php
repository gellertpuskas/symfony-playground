<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "required" => false,
                "label" => "Name"
            ])
            ->add('price')
            ->add("agree", CheckboxType::class, [ "mapped" => false, "label" => "I agree to the Terms and Policies." ])
            ->add("save", SubmitType::class, [ "label" => "Create Pizza" ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
//            'min_name_length' => 3,
        ]);

//        $resolver->setAllowedTypes("min_name_length", "int");
    }
}
