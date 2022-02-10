<?php

namespace App\Controller\Admin;

use App\Entity\Timework;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TimeworkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Timework::class;
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
