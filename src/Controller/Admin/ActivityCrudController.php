<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ActivityCrudController extends AbstractCrudController
{

    /* Image : activity */
    public const ACTIVITY_BASE_PATH = 'upload/images/activities';
    public const ACTIVITY_UPLOAD_DIR = 'public/upload/images/activities';

    /* Image : schedule */
    public const SCHEDULE_BASE_PATH = 'upload/images/activities/schedule';
    public const SCHEDULE_UPLOAD_DIR = 'public/upload/images/activities/schedule';

    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            /* Recup id User connected */
            AssociationField::new('user'),
            TextField::new('company'),
            TextField::new('address'),
            TelephoneField::new('phone_number'),
            IntegerField::new('duration'),
            AssociationField::new('unit'),
            TextField::new('city'),
            TextField::new('name'),
            TextField::new('country'),
            DateTimeField::new('published_at')->hideOnForm(),
            ImageField::new('picture')
                ->setBasePath(self::ACTIVITY_BASE_PATH)
                ->setUploadDir(self::ACTIVITY_UPLOAD_DIR),
            MoneyField::new('price')->setCurrency('USD'),
            TextareaField::new('description'),
        ];
    }


}
