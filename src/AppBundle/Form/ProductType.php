<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;



class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm (FormBuilderInterface $builder, array $option)
    { $builder

        ->add('name')
        ->add('reference')
        ->add('purcharsing_price')
        ->add('rate_price')
        ->add('tva_taxe')

        ->add('send', SubmitType::class)


    ;

    }


}