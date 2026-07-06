<?php

namespace App\Form;

use App\Entity\Business;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Package;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('name')
            ->add('price')
            ->add('photo')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
            ])
            ->add('business', EntityType::class, [
                'class' => Business::class,
                'choice_label' => 'id',
            ])
            ->add('consumer_order', EntityType::class, [
                'class' => Order::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
        ]);
    }
}
