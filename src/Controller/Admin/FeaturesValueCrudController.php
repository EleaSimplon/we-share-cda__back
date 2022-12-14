<?php

namespace App\Controller\Admin;

use App\Entity\FeaturesValue;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FeaturesValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeaturesValue::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('value'),
        ];
    }
}
