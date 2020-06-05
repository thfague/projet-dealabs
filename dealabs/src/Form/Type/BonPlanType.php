<?php
/**
 * Created by PhpStorm.
 * User: Elsword XIII
 * Date: 05/06/2020
 * Time: 18:09
 */

namespace App\Form\Type;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BonPlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lien', TextType::class)
            ->add('prix', MoneyType::class)
            ->add("prixHab", MoneyType::class)
            ->add("fdp", MoneyType::class)
            ->add("livraison", CheckboxType::class)
            ->add("codePromo", TextType::class)
            ->add("nom", TextType::class)
            ->add("description", TextareaType::class)
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
        ;
    }
}