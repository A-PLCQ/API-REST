<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter book title'],
            ])
            ->add('author', TextType::class, [
                'label' => 'Author',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter author name'],
            ])
            ->add('publicationYear', NumberType::class, [
                'label' => 'PublicationYear',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter publication year'],
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter ISBN number'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Book',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
