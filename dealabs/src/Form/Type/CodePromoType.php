<?php
/**
 * Created by PhpStorm.
 * User: Elsword XIII
 * Date: 05/06/2020
 * Time: 18:22
 */

namespace App\Form\Type;


use App\Entity\Categorie;
use App\Entity\Deal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodePromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("lien", TextType::class)
            ->add("typeReduc", ChoiceType::class, [
                "choices" => [
                    "Pourcentage (%)" => 0,
                    "Euro (€)" => 1,
                    "Livraison gratuite" => 2
                ],
            ])
            ->add("codePromo", TextType::class)
            ->add("valeurCodePromo", MoneyType::class, array('currency'=>''))
            ->add("nom", TextType::class)
            ->add("description", TextareaType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'choice_value' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deal::class,
        ]);
    }
}