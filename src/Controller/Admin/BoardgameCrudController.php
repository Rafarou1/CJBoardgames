<?php

namespace App\Controller\Admin;

use App\Entity\Boardgame;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BoardgameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Boardgame::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setRequired(true),
            TextField::new('type'),
            IntegerField::new('difficulty'),
            IntegerField::new('year'),
            AssociationField::new('reserve'),
        ];
    }
    
}
