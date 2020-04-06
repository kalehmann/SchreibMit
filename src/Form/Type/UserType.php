<?php

namespace DrkDD\SchreibMit\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserType
 * @package DrkDD\SchreibMit\Form\Type
 */
class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ages = [
            'form.user.age.group.below_six' => 0,
            'form.user.age.group.six_to_twelve' => 1,
            'form.user.age.group.thirteen_to_sixteen' => 2,
            'form.user.age.group.seventeen_to_twentyseven' => 3,
            'form.user.age.group.above_twentyseven' => 4,
        ];

        $builder
            ->add('name', TextType::class, ['label' => 'form.user.name'])
            ->add('email', TextType::class, ['label' => 'form.user.email'])
            ->add(
                'postalCode',
                TextType::class,
                [
                    'label' => 'form.user.postal_code',
                ]
            )
            ->add(
                'age',
                ChoiceType::class,
                [
                    'label' => 'form.user.age.label',
                    'choices' => $ages,
                    'placeholder' => 'form.user.age.placeholder',
                    'required' => false,
                ]
            )
            ->add('submit', SubmitType::class, ['label' => 'form.user.submit']);
    }
}