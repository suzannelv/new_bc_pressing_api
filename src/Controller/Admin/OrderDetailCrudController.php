<?php

namespace App\Controller\Admin;

use App\Entity\OrderDetail;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderDetailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDetail::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
            ->setPageTitle("index", "Mr.U-Smiley - Administration des commandes")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                    ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('orderNumber')
                    ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('createdAt')
                    ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('depositDate'),
            DateTimeField::new('retrieveDate'),
            AssociationField::new('payment')
                            ->setCrudController(PaymentCrudController::class),
            AssociationField::new('client')
                            ->setCrudController(ClientCrudController::class)
                            ->setFormTypeOption('disabled', 'disabled'),
            AssociationField::new('emp')
                            ->setCrudController(EmployeeCrudController::class),
            AssociationField::new('orderStatus')
                            ->setCrudController(OrderStatusCrudController::class),
            AssociationField::new('productSelected')
                            ->setCrudController(ProductSelectedCrudController::class),
            TextField::new('totalPriceAsString', 'Prix total')
                        ->formatValue(function ($value, OrderDetail $orderDetail) {
                        return $orderDetail->getTotalPriceAsString();
                         })
                            
        ];
    }
    
}
