<?php

namespace App\Controller\Admin;

use App\Entity\Regel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RegelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Regel::class;
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
