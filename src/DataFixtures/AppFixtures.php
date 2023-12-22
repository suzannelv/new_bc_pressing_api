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

    // poduits status
        $productStatusName = ["Nouveau", "Usagé", "Abîmé"];
        foreach ($productStatusName as $statusName) {
            
            $status = new ProductStatus();
            $status->setStatusName($statusName);
            $manager->persist($status);
            $allProductStatus[]=$status;
        }

    // Catégory
        $mainCategories = [
            "Vêtements" => [
                "Haut" => ["Chemises", "T-shirts", "Pulls", "Vestes"],
                "Bas" => ["Pantalons", "Jupes", "Shorts"],
                "Costumes" => ["Ensemble complet", "Veste", "Pantalon", "Jupe"],
                "Autres" => ["Robes", "Tenues de sport", "Vêtements d'extérieur"],
            ],
            "Linge de maison" => [
                "Literie" => ["Draps", "Taies d'oreiller", "Housses de couette"],
                "Serviettes" => ["Serviettes de bain", "Serviettes de cuisine"],
                "Nappes" => ["Nappes", "Sets de table"],
                "Rideaux" => ["Rideaux", "Stores"],
            ],
            "Chaussures et Accessoires" => [
                "Chaussures" => ["Baskets", "Chaussures habillées", "Sandales"],
                "Accessoires" => ["Sacs à main", "Chapeaux", "Ceintures"],
            ],
        ];
        //   boucle catégorie parent
        foreach($mainCategories as $mainCategoryName => $subCategories){
            $mainCategory = new Category();
            $mainCategory->setName($mainCategoryName);
            $manager->persist($mainCategory);
            //  boucle sous-catégorie
            foreach($subCategories as $subCategoryName => $products){
                $subCategory = new Category();
                $subCategory->setName($subCategoryName);
                $manager->persist($subCategory);
            //  Produits
                foreach($products as $productName){
                    $product = new Product();
                    $product
                        ->setName($productName)
                        ->setPrice($faker->randomFloat(2))
                        ->setDescription($faker->paragraph())
                        ->setProductStatus($faker->randomElement($allProductStatus));
                    $subCategory->addProduct($product);
                    $manager->persist($product);
                }
                $mainCategory->addChild($subCategory);

            }
            $manager->persist($mainCategory);
        }
        
        $manager->flush();
    }
}
