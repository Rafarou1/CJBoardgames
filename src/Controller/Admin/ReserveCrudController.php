<?php

namespace App\Controller\Admin;

use App\Entity\Reserve;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ReserveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reserve::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')
            ->setRequired(true),
            TextField::new('description'),
            AssociationField::new('boardgame')
            ->onlyOnDetail()
            ->setTemplatePath('admin/fields/reserve_boardgames.html.twig'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

    return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
    ;
    }
}

