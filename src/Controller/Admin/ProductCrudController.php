<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud 
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPageTitle("index", "Mr.U-Smiley - Administration des produits")
            ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {       

        $imageField = ImageField::new('imagePath')
                    ->setBasePath('/uploads/products')
                    ->setLabel('Image')
                    ->onlyOnIndex(); 

        $imageFileField = TextField::new('imageFile')
        ->setFormType(VichImageType::class)
        ->setFormTypeOptions([
            'allow_delete' => false,
        ])
        ->hideOnIndex();

        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('category')
                            ->setCrudController(CategoryCrudController::class),
            AssociationField::new('productStatus')
                            ->setCrudController(ProductStatusCrudController::class),
            IntegerField::new('price'),
            TextEditorField::new('description'),
            $imageField,
            $imageFileField
        ];

        return $fields;    
    }
}
