<?php

namespace App\Form;

use App\Entity\Lang;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('description')
            ->add('langhasuser', EntityType::class, [
                'class' => Lang::class, //use to get class name
                'choice_label' => 'name', //use to get name of lang
                'expanded' => true,
                'multiple' => true,
                'label' => 'Speak'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
