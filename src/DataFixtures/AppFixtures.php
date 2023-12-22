<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductStatus;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private const NB_PRODUCT = 10;
    public function __construct(private CategoryRepository $categoryRepository){

    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        
        // Catégorie
        $parentCategoriesName = ["Vêtement", "Linge de maison", "Chaussure et Accessoires"];
        $subCategoriesName = ["Haut", "Bas", "Chausures", "Costume et Robe", "Accessoire", "Autres"];
        $allCategories = [];
        foreach($parentCategoriesName as $parentName) {
            $mainCategory = new Category();
            $mainCategory
                ->setName($parentName);
             
                
            $manager->persist($mainCategory);
            $allCategories[]=$mainCategory;

            foreach($subCategoriesName as $subCategoryName){
                $subCategory = new Category();
                $subCategory
                    ->setName($subCategoryName)
                    ->setParent($mainCategory);    
                $manager->persist($subCategory); 
                $allCategories[]=$subCategory;
            }
        }

        // Produits
        $productStatusName = ["Nouveau", "Usagé", "Abîmé"];
        $allProductStatus = [];
        foreach ($productStatusName as $statusName) {
            
            $status = new ProductStatus();
            $status->setStatusName($statusName);
            $manager->persist($status);
            $allProductStatus[]=$status;
        }


        // $allCategories = $this->categoryRepository->findAll();
        // var_dump($allCategories);

        for($i=0; $i<self::NB_PRODUCT; $i++) {
            $product = new Product();
            $product
                ->setName($faker->word())
                ->setPrice($faker->randomFloat(2))
                ->setDescription($faker->paragraph())
                ->setProductStatus($faker->randomElement($allProductStatus))
                ->setCategory($faker->randomElement($allCategories));
            $manager->persist($product);
        }
        
        $manager->flush();
    }
}
