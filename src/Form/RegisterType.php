<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,  
                ['label' => ' Votre prénom', 
                'constraints' => new Length([
                    'min' => 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom']
                
                ])
            ->add('lastname', TextType::class,
             ['label' => ' Votre Nom', 
              'constraints' => new Length([
                'min' => 4,
                'max'=> 30
            ]), // Contrainte permettant de donner une tranche de caractères possible 
             'attr' => [ // Attr 
                 'placeholder' => 'Veuillez saisir votre Nom']])
            ->add('email', EmailType::class,
            ['label' => ' Votre E-mail', 
            'attr' => [
                'placeholder' => 'Veuillez saisir votre E-mail']])
            ->add('password', RepeatedType::class,
            [   'type'=> PasswordType::class,
                'invalid_message'=> 'Les mots de passes ne sont pas identiques',
                'label' => ' Votre Mot de passe', 
                'required' => true,
                'first_options'=> ['label'=> 'Mot de passe'],
                'second_options' =>[ 'label'=> 'Confirmez votre mot de passe'],
            'attr' => [
                'placeholder' => 'Veuillez saisir votre MDP']])
            
            ->add('Valider', SubmitType::class)
        ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
