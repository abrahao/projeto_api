<?php

namespace App\Form;

use App\Entity\Socio;
use App\Entity\Empresa;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Nome'
            ])
            ->add('cpf', TextType::class, [
                'label' => 'CPF'
            ])
            ->add('telefone', TextType::class, [
                'label' => 'Telefone',
                'required' => false
            ])
            ->add('empresa', EntityType::class, [
                'class' => Empresa::class,
                'choice_label' => 'nome',
                'label' => 'Empresa'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
