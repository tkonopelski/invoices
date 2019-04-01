<?php

namespace App\Form;

use App\Entity\InvoiceItem;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class InvoiceItemFormType
 * @package App\Form
 *
 * https://symfony.com/doc/current/reference/forms/types.html
 *
 */
class InvoiceItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a quantity',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096, // max length allowed by Symfony for security reasons
                    ]),
                ],
            ])
            ->add('price', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a price',
                    ]),
                    new Length([
                        'min' => 0,
                        'minMessage' => 'Your price should be at least {{ limit }} characters',
                        'max' => 4096, // max length allowed by Symfony for security reasons
                    ]),
                ],
            ])
            ->add('item_name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a namne',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Your name should be at least {{ limit }} characters',
                        'max' => 4096, // max length allowed by Symfony for security reasons
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceItem::class,
        ]);
    }
}
