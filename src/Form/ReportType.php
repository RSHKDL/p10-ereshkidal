<?php

namespace App\Form;

use App\Entity\AbstractReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * Class ReportType
 * @author ereshkidal
 */
class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('motive', ChoiceType::class, [
            'placeholder' => 'Choose a motive',
            'choices' => [
                'Offensive Content' => 'offensive_content',
                'Incorrect Content' => 'incorrect_content',
                'Other' => 'other'
            ],
            'required' => true,
        ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var AbstractReport|null $data */
                $data = $event->getData();
                if (!$data) {
                    return;
                }
                $this->setupSpecificMotiveField(
                    $event->getForm(),
                    $data->getMotive()
                );
            }
        );

        $builder->get('motive')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) {
                $form = $event->getForm();
                $this->setupSpecificMotiveField(
                    $form->getParent(),
                    $form->getData()
                );
            }
        );
    }

    /**
     * @param string $motive
     * @return array|null
     */
    private function getSpecificMotiveChoices(string $motive): ?array
    {
        $offensive = [
            'Inflammatory',
            'Vulgar',
            'Personal Attack',
        ];
        $incorrect = [
            'Missing Source',
            'Grammatical errors',
            'Off Topic',
        ];
        $motiveChoices = [
            'offensive_content' => array_combine($offensive, $offensive),
            'incorrect_content' => array_combine($incorrect, $incorrect),
            'other' => null,
        ];

        return $motiveChoices[$motive];
    }

    private function setupSpecificMotiveField(FormInterface $form, ?string $motive): void
    {
        if (null === $motive) {
            $form->remove('specificMotive');

            return;
        }

        $choices = $this->getSpecificMotiveChoices($motive);

        if (null === $choices) {
            $form->remove('specificMotive');

            return;
        }

        $form->add('specificMotive', ChoiceType::class, [
            'placeholder' => 'Please specify...',
            'choices' => $choices,
            'required' => false
        ]);
    }
}
