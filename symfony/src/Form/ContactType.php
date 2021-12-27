<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sender', null, [
                'label' => 'Expéditeur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut être vide',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'L\'expéditeur doit contenir au moins {{ limit }} caractères'
                    ])
                    ],
                    'help' => 'Veuillez entrer un nom d\'au moins 5 caractères',
            ])
            ->add('subject', null, [
                'required' => false,
            ])
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
