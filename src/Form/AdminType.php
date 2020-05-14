<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('address',TextType::class)
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'male' => 'male',
                    'female' => 'female'
                ),
            ))
            ->add('dob',DateType::class)
            ->add('mobile',TextType::class)
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'student' => 'student',
                    'teacher' => 'teacher',
                    'admin' => 'admin'
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}