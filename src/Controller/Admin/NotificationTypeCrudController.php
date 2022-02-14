<?php

namespace App\Controller\Admin;

use App\Entity\NotificationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NotificationTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NotificationType::class;
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
