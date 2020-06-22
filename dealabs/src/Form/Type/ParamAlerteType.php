<?php
/**
 * Created by PhpStorm.
 * User: Elsword XIII
 * Date: 22/06/2020
 * Time: 19:06
 */

namespace App\Form\Type;


use App\Entity\ParamAlerte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParamAlerteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("motsCles", TextType::class)
            ->add("noteMin", IntegerType::class)
            ->add("mail", CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParamAlerte::class,
        ]);
    }
}