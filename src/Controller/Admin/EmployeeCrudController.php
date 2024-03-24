<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Employée')
            ->setEntityLabelInPlural('Employées')
            ->setPageTitle("index", "Mr.U-Smiley - Administration des employées")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                    ->hideOnForm(),
            TextField::new('empNumber'),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('email')
                    ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('password')
                    ->hideOnIndex()
                    ->hideOnForm(),
            TextField::new('phoneNumber')
                    ->setFormTypeOption('disabled', 'disabled') ,
            TextField::new('adress'),
            AssociationField::new('zipCode')
                ->setCrudController(ZipCodeCrudController::class)
                ->hideOnIndex(),
            ArrayField::new('roles')
                    ->hideOnIndex(),
            DateTimeField::new('createdAt')
                    ->setFormTypeOption('disabled', 'disabled')
        ];
    }
}
