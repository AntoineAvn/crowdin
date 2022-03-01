<?php

namespace App\Form;

use App\Entity\Lang;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('lang')
            ->add('langtotranslate', EntityType::class, [
                'class' => Lang::class, //use to get class name
                'choice_label' => 'name', //use to get name of lang
                'expanded' => true,
                'multiple' => true,
                'label' => 'Need to be translate in:'
            ])
            // ->add('block_sources')
            // ->add('is_deleted')
            // ->add('date_add')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
