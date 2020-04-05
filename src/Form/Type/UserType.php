<?php

namespace DrkDD\Pflegefinder\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserType
 * @package DrkDD\Pflegefinder\Form\Type
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ages = [
            '<6' => 0,
            '6-12' => 1,
            '13-16' => 2,
            '17-27' => 3,
            '>27' => 4,
        ];

        $builder
            ->add('name', TextType::class, ['label' => 'Name oder Synonym'])
            ->add('email', TextType::class, ['label' => 'E-Mail Adresse'])
            ->add(
                'postalCode',
                TextType::class,
                [
                    'label' => 'Postleitzahl',
                ]
            )
            ->add(
                'age',
                ChoiceType::class,
                [
                    'label' => 'Alter (optional)',
                    'choices' => $ages,
                    'placeholder' => 'leer',
                    'required' => false,
                ]
            )
            ->add('submit', SubmitType::class, ['label' => 'Abschicken']);
    }
}