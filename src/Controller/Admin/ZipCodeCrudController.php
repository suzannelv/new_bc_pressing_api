<?php

namespace App\Controller\Admin;

use App\Entity\ZipCode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ZipCodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ZipCode::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Code postal')
            ->setEntityLabelInPlural('Codes postaux')
            ->setPageTitle("index", "Mr.U-Smiley - Administration des codes postaux")
            ->setPaginatorPageSize(10);
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
