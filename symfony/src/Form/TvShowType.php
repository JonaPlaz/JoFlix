<?php

namespace App\Form;

use App\Entity\TvShow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TvShowType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('title', null, [
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('synopsis')
      ->add('image')
      ->add('publishedAt', null, [
        'widget' => 'single_text',
      ])
      ->add('categories')
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => TvShow::class,
    ]);
  }
}
