<?php

namespace App\Form;
use App\Entity\Animals;
use App\Entity\Users;

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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class AnimalsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder //input  name="name"(same as in the db!) type="text" class="form-control mb-2"
       ->add('name', TextType::class, ['attr'=>["class"=>"form-control mb-2", "placeholder"=>"Type animal name"]])
       ->add('breed', TextType::class, ['attr'=>["class"=>"form-control mb-2", "placeholder"=>"Type animal breed"]])
       ->add('description', TextType::class, ['attr'=>["class"=>"form-control mb-2", "placeholder"=>"Type animal description"]])
       ->add('picture', FileType::class, [
                'attr'=>["class"=>"form-control mb-2"],
                'label' => 'Upload Picture',
        //unmapped means that is not associated to any entity property
                'mapped' => false,
        //not mandatory to have a file
                'required' => false,
        //in the associated entity, so you can use the PHP constraint classes as validators
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
       ->add('age', NumberType::class, ['attr'=>["class"=>"form-control mb-2", "placeholder"=>"Type animal age"]])
       ->add('fk_user', EntityType::class, [
           'class'=> Users::class,
           'choice_label' => 'name',
           'attr' => ['class' => 'ms-5 mt-4 mb-3']
        ])
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