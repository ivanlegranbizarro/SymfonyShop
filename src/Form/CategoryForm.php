<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'block w-full mt-2 rounded-xl border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2';
        $labelClass = 'block text-sm font-medium text-gray-700 mb-2';
        $rowClass = 'mb-6';

        $builder
            ->add('name', null, [
                'label' => 'Category Name',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => [
                    'class' => $inputClass,
                    'required' => true,
                    'minlength' => 3,
                    'maxlength' => 255,
                    'placeholder' => 'Enter category name'
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'label_attr' => ['class' => $labelClass],
                'row_attr' => ['class' => $rowClass],
                'attr' => [
                    'class' => "$inputClass h-32 resize-none",
                    'required' => true,
                    'minlength' => 10,
                    'maxlength' => 500,
                    'placeholder' => 'Enter category description'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
}
