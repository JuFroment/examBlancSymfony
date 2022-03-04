<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints'=> [
                    new Assert\Callback(['callback'=> static function (?string $value, ExecutionContextInterface $context) {
                        if ((explode('@', $value)[1]) != 'deloitte.com') {
                            $context
                                ->buildViolation("L'adresse mail doit forcément se terminer par @deloitte.com")
                                ->atPath('[email]')
                                ->addViolation();
                        }
                    }])
    ]] )
            ->add('nom')
            ->add('prenom')
            ->add('photo')
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'Direction' => 'Direction',
                    'Comptabilité' => 'Comptabilité',
                    'Informatique' => 'Informatique',
                    'Recrutement' => 'Recrutement',
                ],
                'expanded' => true
            ])
            ->add('roles')
            ->add('password', PasswordType::class, [
                'constraints'=> [
                    new Length(
                        min: 8,
                        minMessage: 'Votre mot de passe doit avoir au minimum 8 caractères'
                    ),
                    new Assert\Callback(['callback'=> static function (?string $value, ExecutionContextInterface $context) {
                        if (!\preg_match('[\d+]', $value)) {
                            $context
                                ->buildViolation("Le mot de passe doit contenir au moins un chiffre")
                                ->atPath('[password]')
                                ->addViolation();
                        }
                        if (!\preg_match('/[a-zA-Z]/', $value)) {
                            $context
                                ->buildViolation("Le mot de passe doit contenir au moins une lettre")
                                ->atPath('[password]')
                                ->addViolation();
                        }
                    }])
                ]
            ]);
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                fn ($rolesAsArray)=>count($rolesAsArray) ? $rolesAsArray[0] : null,
                fn ($rolesAsString) => [$rolesAsString])
            )
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
