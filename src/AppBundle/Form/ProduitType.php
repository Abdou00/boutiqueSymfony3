<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('reference')
            -> add('categorie')
            -> add('titre')
            -> add('description')
            -> add('couleur')
            -> add('taille')
            -> add('public')
            -> add('photo')
            -> add('prix')
            -> add('stock')
            -> add('save', SubmitType::class, array('label' => 'Ajouter'));
    }
}
