<?php

namespace App\Form;

use App\Entity\Armoire;
use App\Repository\BoardgameRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $armoire = $options['data'] ?? null;
        $player = $armoire->getPlayer();

        $builder
            ->add('description')
            ->add('published')
            ->add('player')
            ->add('boardgame')
            //     'query_builder' => function (BoardgameRepository $er) use ($player) {
            //         return $er->createQueryBuilder('g')
            //         ->leftJoin('g.reserve', 'i')
            //         ->andWhere('i.member = :player')
            //         ->setParameter('player', $player);
            //     }
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Armoire::class,
        ]);
    }
}
