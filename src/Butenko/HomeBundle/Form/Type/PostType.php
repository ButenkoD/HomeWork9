<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 12/4/13
 * Time: 3:50 PM
 */

namespace Butenko\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('email', 'email')
            ->add('body', 'text')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'post';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Butenko\HomeBundle\Entity\Post'
        ));
    }
}