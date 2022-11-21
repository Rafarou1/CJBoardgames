<?php

namespace App\Controller\Admin;

use App\Entity\Armoire;
use Doctrine\DBAL\Query\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArmoireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
    return Armoire::class;
    }

    public function configureFields(string $pageName): iterable
    {

    return [
        IdField::new('id')->hideOnForm(),
        AssociationField::new('[creator]'),
        BooleanField::new('published')
        ->onlyOnForms()
        ->hideWhenCreating(),
        TextField::new('description'),

        AssociationField::new('[objets]')
        ->onlyOnForms()
        // on ne souhaite pas gérer l'association entre les
        // [objets] et la [galerie] dès la crétion de la
        // [galerie]
        ->hideWhenCreating()
        ->setTemplatePath('admin/fields/[inventaire]_[objets].html.twig')
        // Ajout possible seulement pour des [objets] qui
        // appartiennent même propriétaire de l'[inventaire]
        // que le [createur] de la [galerie]
        ->setQueryBuilder(
            function (QueryBuilder $queryBuilder) {
            // récupération de l'instance courante de [galerie]
            $currentArmoire = $this->getContext()->getEntity()->getInstance();
            $player = $currentArmoire->getArmoire();
            $memberId = $player->getId();
            // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le [createur] de la galerie
            $queryBuilder->leftJoin('entity.reserve', 'i')
                ->leftJoin('i.owner', 'm')
                ->andWhere('m.id = :member_id')
                ->setParameter('member_id', $memberId);    
            return $queryBuilder;
            }
           ),
    ];
    }
}