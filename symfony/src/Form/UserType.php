<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email')
      ->add('roles', ChoiceType::class, [
        'multiple' => false,
        'choices' => [
          'Admin' => 'ROLE_ADMIN',
          'Utilisateur' => 'ROLE_USER',
        ],
        'expanded' => true,
      ])
      ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'first_options'  => ['label' => 'Mot de passe'],
        'second_options' => ['label' => 'Confirmez le mot de passe'],
        'invalid_message' => 'Les deux mots de passe doivent être identiques',
        'required' => false,
        'mapped' => false,
      ])

      ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

        $user = $event->getData();
        $form = $event->getForm();

        if ($user->getId() === null) {

          $form->remove('password');

          $form->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmez le mot de passe'],
            'invalid_message' => 'Les deux mots de passe doivent être identiques',
            'required' => true,
            'mapped' => false,
            'constraints' => [
              new NotBlank(),
            ]
          ]);
        }
      });

    $builder->get('roles')->addModelTransformer(new CallbackTransformer(

      function ($tagsAsArray) {

        return $tagsAsArray[0];
      },

      function ($tagsAsString) {

        return [$tagsAsString];
      }
    ));
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
