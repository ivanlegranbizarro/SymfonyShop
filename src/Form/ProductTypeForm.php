<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'block w-full mt-2 rounded-xl border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2';
        $labelClass = 'block text-sm font-medium text-gray-700 mb-2';
        $rowClass = 'mb-6';

        $builder
            ->add('name', null, [
                'label' => 'Product Name',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => ['class' => $inputClass, 'minlength' => 3, 'maxlength' => 255],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => ['class' => "$inputClass h-32 resize-none", 'minlength' => 10, 'maxlength' => 500],
            ])
            ->add('price', null, [
                'label' => 'Price (€)',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => ['class' => $inputClass, 'min' => 0.01, 'step' => '0.01', 'type' => 'number'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Product Image',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => ['class' => $inputClass . ' cursor-pointer', 'accept' => 'image/*'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => ['class' => $inputClass],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
