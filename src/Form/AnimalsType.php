<?php

namespace App\Form;

// use App\Entity\Animals;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;


class AnimalsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder //input  name="name"(same as in the db!) type="text" class="form-control mb-2"
       ->add('name', TextType::class, ['attr'=>["class"=>"form-control mb-2"]])
       ->add('breed', TextType::class, ['attr'=>["class"=>"form-control mb-2"]])
       ->add('description', TextType::class, ['attr'=>["class"=>"form-control mb-2"]])
       ->add('age', NumberType::class, ['attr'=>["class"=>"form-control mb-2"]])
       ->add('save', SubmitType::class, [
           'label' => 'Save',
           'attr' => ['class' => 'btn btn-primary mt-4 mb-5']
       ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          //'data_class' => Animals::class,
      ]);
  }
}