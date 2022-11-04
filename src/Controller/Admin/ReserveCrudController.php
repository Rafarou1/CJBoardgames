<?php

namespace App\Controller\Admin;

use App\Entity\Reserve;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReserveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reserve::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
