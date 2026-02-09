<?php

namespace App\Form; 

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;


class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    ->add('nom', TextType::class, [
        'label' => 'Nom',
        'constraints' => [
            new Assert\Length([
                'min' => 2,
                'max' => 50,
                'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
            ]),
            new Assert\NotBlank([
                'message' => 'Le nom est obligatoire.',
            ]),
        ],
    ])
    ->add('prenom', TextType::class, [
        'label' => 'Prénom',
        'constraints' => [
            new Assert\Length([
                'min' => 2,
                'max' => 50,
                'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères.',
                'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.',]),
            new Assert\NotBlank(),
        ],
    ])
    ->add('email', EmailType::class, [
        'label' => 'Email',
        'constraints' => [
            new Assert\Email(['message' => 'Email invalide.']),
            new Assert\Length(['max' => 180]),
            new Assert\NotBlank(),
        ],
    ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
