<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Material;
use App\Entity\Product;
use App\Entity\ProductSelected;
use App\Entity\ProductStatus;
use App\Entity\ServiceOption;
use App\Utils\PriceCalculator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture implements DependentFixtureInterface
{

    private const NB_PRODUCT = 10;
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

    // poduits status
        $productStatusName = ["Nouveau", "Usagé", "Abîmé"];
        $allProductStatus = [];
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
        
        // matériel

        $materialInfos=[
            [
                "name"=>"Coton",
                "coefficentPrice"=>0.1
            ],
            [
                "name"=>"Lin",
                "coefficentPrice"=>0.2
            ],  
            [
                "name"=>"Laine",
                "coefficentPrice"=>0.3
            ],  
            [
                "name"=>"Polytester",
                "coefficentPrice"=>0.1
            ],  
            [
                "name"=>"Soie",
                "coefficentPrice"=>0.5
            ],  
            [
                "name"=>"Denim",
                "coefficentPrice"=>0.2
            ],

        ];
        $allMaterials=[];
        foreach($materialInfos as $materialInfo) {
            $material = new Material();
            $material->setName($materialInfo["name"])
                     ->setCoefficentPrice($materialInfo['coefficentPrice']);
            
            $allMaterials[]=$material;

            $manager->persist($material);
            
        }

        //service options

        $serviceInfos =[
            [
                "name"=>"Lavage",
                "coefficentPrice"=>0.1
            ],
            [
                "name"=>"Repassage",
                "coefficentPrice"=>0.1
            ],  
            [
                "name"=>"Nettoyage à sec",
                "coefficentPrice"=>0.3
            ],  
            [
                "name"=>"Blanchiment",
                "coefficentPrice"=>0.1
            ],  
            [
                "name"=>"Détachement ",
                "coefficentPrice"=>0.2
            ],  
            [
                "name"=>"Retouche",
                "coefficentPrice"=>0.2
            ],
            [
                "name"=>"entretien spécial",
                "coefficentPrice"=>0.3
            ],
        ];

        $allServices=[];
        foreach($serviceInfos as $service){
            $serviceOption = new ServiceOption();
            $serviceOption->setName($service["name"])
                          ->setCoefficentPrice($service["coefficentPrice"]);
            
            $manager->persist($serviceOption);
            $allServices[]=$serviceOption;
        }

        // produits sélectionnés
        $priceCalculator = new PriceCalculator();
        
        
        $orderDetail = $this->getReference(UserFixtures::ORDER_DETAIL);
        
        $productSelected = new ProductSelected();
        $productSelected->setProduct($product)
                        ->setMaterial($faker->randomElement($allMaterials))
                        ->setOrderDetail($orderDetail);
                     
        $nbServices = $faker->numberBetween(1, 3);
        $servicesSelected = [];
        for($i=0; $i<$nbServices; $i++){
          $servicesSelected[] = $faker->randomElement($allServices);
            
        }

        $totalPrice = $priceCalculator->calculateTotalPrice($product, $servicesSelected);
        $productSelected->setTotalPrice($totalPrice);

        foreach($servicesSelected as $service) {
            $productSelected->addServiceOption($service);
            $manager->persist($service);
        }
        $manager->persist($productSelected);

        $manager->flush();
    }

    public function getDependencies(){
        return [
          UserFixtures::class,
        ];
    }

}
