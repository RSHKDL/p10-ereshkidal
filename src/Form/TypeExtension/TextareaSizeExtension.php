<?php

namespace App\Form\TypeExtension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TextareaSizeExtension
 * @author ereshkidal
 *
 * https://symfony.com/doc/4.4/form/create_form_type_extension.html
 */
class TextareaSizeExtension extends AbstractTypeExtension
{
    public function getExtendedTypes(): iterable
    {
        return [
            TextareaType::class
        ];
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr']['rows'] = $options['rows'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'rows' => 5
        ]);
    }
}
