<?php

namespace BRT\BlogBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postTitle', TextType::class, [
                "required" => true
            ])
            ->add('postSubtitle', TextType::class, [
                "required" => false
            ])
            ->add('postText', HiddenType::class,[
                "required" => true
            ])
            ->add('postImageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                "label" => false,
                "attr" => [
                    'class'     => "file-styled"
                ]
            ])
            ->add('created', TextType::class, [
                "required" => true,
            ])
            ->add('user');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BRT\BlogBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'brt_blogbundle_post';
    }


}
