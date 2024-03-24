<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle("index", "Mr.U-Smiley - Administration des catégories")
            ->setPaginatorPageSize(10)
            ->overrideTemplate('crud/index', 'bundles/EasyAdminBundle/category/category.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('displayName', 'Name')->onlyOnIndex(),
            TextField::new('name')->hideOnIndex(),
            AssociationField::new('parent')
                        ->setCrudController(CategoryCrudController::class)
                        ->setFormTypeOptions([
                            'by_reference' => false,
                        ])
                        ->hideWhenCreating(),
        ];
    }
}
