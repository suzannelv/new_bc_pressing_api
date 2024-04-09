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
    private const NB_PRODUCT_SELECTED = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        // poduits status 
        $allProductStatus = [];
        $productStatusName = ["Nouveau", "Usagé", "Abîmé"];
        foreach ($productStatusName as $statusName) {
            $status = new ProductStatus();
            $status->setStatusName($statusName);
            $manager->persist($status);
            $allProductStatus[] = $status;
        }

        // Catégory
        $mainCategories = [
            "Vêtements" => [
                "Haut" => [
                    "Chemises"=>[
                        "price"      =>5,
                        "description"=>"Votre chemise préférée, impeccablement repassée, reflète notre savoir-faire traditionnel. Chez nous, vos vêtements sont traités avec le plus grand soin : notre équipe de professionnels du pressing prend soin de chaque détail de votre chemise avec dévouement et expertise.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/nature-morte-chemises-classiques-cintre_23-2150828570.jpg?w=1380&t=st=1707583145~exp=1707583745~hmac=ce09e5180df200558633fd6ab4cbc67ed8ffe3cfc1fe71696d22594367a5641a"
                    ],
                    
                    "T-shirts"=>[
                        "price"      =>2,
                        "description"=>"Chez nous, chaque t-shirt est traité avec le même dévouement et le même professionnalisme, qu'il s'agisse d'un vêtement décontracté ou d'une pièce de collection. Notre équipe dévouée veille à ce que chaque pli soit parfaitement lisse, et que chaque détail soit impeccable.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/concept-maquette-chemise-vetements-unis_23-2149448792.jpg?w=740&t=st=1707583244~exp=1707583844~hmac=4eeeb2f0974e5683a569533af45c570158e95e89195f149d1aa79181cdc93e42"
                    
                    ], 
                    "Pulls"=>[
                        "price"      =>5,
                        "description"=>"Votre pull préféré mérite un traitement de qualité, et c'est exactement ce que nous offrons. Avec notre expertise dans le domaine du pressing, nous traitons chaque pull avec le plus grand soin, préservant sa douceur, sa forme et sa couleur d'origine.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/close-up-articles-tricotes-soigneusement-plies-couleur-pastel_169016-7137.jpg?w=1380&t=st=1707583379~exp=1707583979~hmac=7ed1fb16e741c96d16b11017914e5e71104981f692b27ec12699fdfda578e7d8"
                    
                    ], 
                    "Vestes" => [
                        "price"      =>8,
                        "description"=>"Votre veste est bien plus qu'un simple vêtement ; c'est une pièce essentielle de votre garde-robe, un symbole de style et de sophistication. Chez nous, nous comprenons l'importance de préserver la qualité et l'élégance de votre veste, c'est pourquoi nous offrons un service de pressing exceptionnel.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/gros-plan-femme-heureuse-tenant-cintres_23-2149241359.jpg?w=1380&t=st=1707583605~exp=1707584205~hmac=fc904c8ec1099ae6313d7a27677e1cbc14703c2d0a11700f0f3620853b42aab0"
                    ], 
                    "Sweat" => [
                        "price"      =>6,
                        "description"=>"Votre veste est bien plus qu'un simple vêtement ; c'est une pièce essentielle de votre garde-robe, un symbole de style et de sophistication. Chez nous, nous comprenons l'importance de préserver la qualité et l'élégance de votre veste, c'est pourquoi nous offrons un service de pressing exceptionnel.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/jerzees-pull-molletonne-capuche_126278-97.jpg?w=900&t=st=1707583699~exp=1707584299~hmac=36585012db5aa525a8a5a64e9bfc5342df73e0851678a190f68ede62d6df41be"
                    ], 
                    "Trench" => [
                        "price"      =>10,
                        "description"=>"Votre trench-coat est bien plus qu'un simple vêtement de pluie ; c'est une pièce emblématique de style et de sophistication, un symbole intemporel de l'élégance urbaine. Chez nous, nous comprenons l'importance de préserver la qualité et l'authenticité de votre trench-coat, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img01.ztat.net/article/spp-media-p1/abf7a05caeac4e38b8e5de8d8043a248/fe6464c03e1443198b6f4b6f5a0d8e9c.jpg?imwidth=1800&filter=packshot"
                    ],
                    "Manteau" => [
                        "price"      =>12,
                        "description"=>"Notre équipe de spécialistes en pressing est dédiée à prendre soin de chaque détail de votre manteau. Que ce soit un manteau en laine luxueuse, un trench-coat élégant ou un parka pratique, nous utilisons des techniques de nettoyage avancées pour préserver les tissus, les couleurs et les finitions de votre manteau.",
                        "imagePath"  => "https://plus.unsplash.com/premium_photo-1674719144570-0728faf14f96?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTN8fG1hbnRlYXV8ZW58MHx8MHx8fDA%3D"
                    ], 
                    "Doudoune" => [
                        "price"      =>15,
                        "description"=>"Que vous portiez votre doudoune pour affronter les rigueurs de l'hiver ou pour compléter une tenue décontractée, notre service de pressing spécialisé assure un traitement adapté à ce vêtement essentiel.",
                        "imagePath"  => "https://www.celio.com/dw/image/v2/BGBR_PRD/on/demandware.static/-/Sites-celio-master/default/dwb64241dc/hi-res/159583-2155-FUPARIGI_LICHENGREEN-1.jpg?sw=599&sh=771&sm=fit"
                    ]],
                "Bas" => [
                    "Pantalons" => [
                        "price"      =>5,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque pantalon avec le plus grand soin. Que ce soit pour éliminer les plis tenaces, raviver les couleurs ou restaurer la texture du tissu, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://plus.unsplash.com/premium_photo-1663011451946-6b8d681b4737?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ], 
                    "Jeans" => [
                        "price"      =>6,
                        "description"=>"Votre jean est bien plus qu'un simple pantalon ; c'est un symbole de décontraction, de style et de durabilité. Chez nous, nous comprenons l'importance de préserver la qualité et le caractère unique de votre jean, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1604176354204-9268737828e4?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ],
                    "Jupe courte" =>[
                        "price"      =>4,
                        "description"=>"Votre jupe courte est une pièce polyvalente de votre garde-robe, alliant féminité et élégance. Chez nous, nous comprenons l'importance de préserver la qualité et la silhouette de votre jupe courte, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/jolie-femme-fashion-marchant-dans-rues-vieille-ville_158595-2818.jpg?w=1380&t=st=1707584579~exp=1707585179~hmac=26bde2495ba43643e61f185dab74096ca3cdb2648284f4d29fcf661faf251647"
                    ], 
                    "Jupe longue" => [
                        "price"      =>5,
                        "description"=>"Votre jupe longue est une pièce polyvalente de votre garde-robe, alliant féminité et élégance. Chez nous, nous comprenons l'importance de préserver la qualité et la silhouette de votre jupe longue, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/portrait-plein-air-belle-dame-mode-debout-contre-voiture-arriere-plan-mode-feminine-mode-vie-ville_132075-9066.jpg?w=740&t=st=1707584808~exp=1707585408~hmac=8b0a93ab5017d3422decf388b5b40f0fcc2c96dd6af1d35cc0884e88351aed25"
                    ], 
                    "Shorts" => [
                        "price"      =>4,
                        "description"=>"Votre short est l'incarnation même de la décontraction et du confort pendant les journées ensoleillées. Chez nous, nous comprenons l'importance de préserver la qualité et la fraîcheur de votre short, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/pantalons-courts-pour-hommes-decontractes_1203-8186.jpg?w=900&t=st=1707585020~exp=1707585620~hmac=0f0c7cbc19ebced25c1bf3c32842b0f7b4dab93c28f4d46d3174bc5ef35fc342"
                    ],  
                    "Pantalon de ski" => [
                        "price"      =>8,
                        "description"=>"Votre pantalon de ski est bien plus qu'un simple vêtement technique ; c'est un élément crucial de votre équipement pour affronter les pentes enneigées avec confort et style. Chez nous, nous comprenons l'importance de préserver la qualité, la fonctionnalité et la performance de votre pantalon de ski, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://www.dopesnow.com/images/H1521_01_To5N3ne.jpg?w=525&dpr=2"
                    ], 
                    "Salopette" => [
                        "price"      =>6,
                        "description"=>"Votre salopette incarne l'esprit de l'aventure et de la praticité, offrant à la fois confort et style lors de vos journées actives. Chez nous, nous comprenons l'importance de préserver la qualité et la robustesse de votre salopette, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img01.ztat.net/article/spp-media-p1/f81ea9293e474bf08a05707afa4bc336/9c7eac1feb19497283c912b4997cb5fe.jpg?imwidth=762&filter=packshot"
                    ] ],
                "Costumes" => [
                    "Ensemble complet" => [
                        "price"      =>19,
                        "description"=>"Votre costume est bien plus qu'un simple ensemble de vêtements ; c'est une expression de votre style personnel, un symbole de professionnalisme et d'élégance. Chez nous, nous comprenons l'importance de préserver la qualité, la coupe et l'apparence impeccable de votre costume, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ], 
                    "Veste" => [
                        "price"      =>10,
                        "description"=>"Votre costume est bien plus qu'un simple ensemble de vêtements ; c'est une expression de votre style personnel, un symbole de professionnalisme et d'élégance. Chez nous, nous comprenons l'importance de préserver la qualité, la coupe et l'apparence impeccable de votre costume, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img01.ztat.net/article/spp-media-p1/4ffa769636713e14adea4de2851f04ff/6dfc7d0ba9974063822253e45e7e0d9e.jpg?imwidth=1800&filter=packshot"
                    ], 
                    "Pantalon" => [
                        "price"      =>10,
                        "description"=>"Votre costume est bien plus qu'un simple ensemble de vêtements ; c'est une expression de votre style personnel, un symbole de professionnalisme et d'élégance. Chez nous, nous comprenons l'importance de préserver la qualité, la coupe et l'apparence impeccable de votre costume, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img01.ztat.net/article/spp-media-p1/1ae16ce3391432f2b757e3e161ff7d5f/435f4d2629844525ac658fd59a95b803.jpg?imwidth=1800&filter=packshot"

                    ]],
                "Robes" => [
                    "Robe simple" => [
                        "price"      =>6,
                        "description"=>"Votre robe est l'essence même de l'élégance et du raffinement, incarnant votre style personnel et votre grâce naturelle. Chez nous, nous comprenons l'importance de préserver la beauté, la délicatesse et la coupe parfaite de votre robe, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/robe-femme-graphique-design-tendance-fond-blanc_460848-13623.jpg?w=740&t=st=1707585872~exp=1707586472~hmac=ae0f9b7e7bd0fdd7145926c7fc82f1a6969911b21d2a6a4432fc5cf59bfa34e6"
                    ], 
                    "Robe de mariée" => [
                        "price"      =>100,
                        "description"=>"Votre journée de mariage est un moment magique, et votre robe est l'élément central de cette célébration. Notre service de pressing spécialisé assure un traitement adapté à ce vêtement précieux, afin qu'il brille de tout son éclat lors de votre grand jour.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/robe-mariee-est-suspendue-chaussures-mariee-au-premier-plan-sont-poof_8353-9860.jpg?w=740&t=st=1707586127~exp=1707586727~hmac=ba1384de78700b017935e98428d54702c46f1b1d619735969725780adf79275c"
                    ], 
                    "Robe de soirée" => [
                        "price"      =>20,
                        "description"=>"Votre journée de mariage est un moment magique, et votre robe est l'élément central de cette célébration. Notre service de pressing spécialisé assure un traitement adapté à ce vêtement précieux, afin qu'il brille de tout son éclat lors de votre grand jour.",
                        "imagePath"  => "https://img01.ztat.net/article/spp-media-p1/ac4a154f892c40659b35f0f0324667cc/77660dddaff4440894df0ca52249d465.jpg?imwidth=1800&filter=packshot"
                    ]],
                "Autres" => [
                    "Pyjama ensemble" => [
                        "price"      =>10,
                        "description"=>"Votre pyjama est votre allié ultime pour des nuits de repos confortables et paisibles. Chez nous, nous comprenons l'importance de préserver la douceur, le confort et la fraîcheur de votre pyjama, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1605131545453-6044234368a6?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ], 
                    "Combinaison de travail" =>[
                        "price"      =>10,
                        "description"=>"Votre combinaison de travail est bien plus qu'un simple vêtement ; c'est un outil essentiel de votre profession, alliant fonctionnalité et durabilité pour répondre aux exigences de votre métier. Chez nous, nous comprenons l'importance de préserver la qualité, la résistance et le confort de votre combinaison de travail, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://mokatex.fr/wp-content/uploads/2023/02/combinaison-de-travail-grise.jpg"
                    ], 
                    "Blouse médicale" => [
                        "price"      =>5,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque détail de votre blouse médicale avec le plus grand soin. Que ce soit pour éliminer les taches tenaces, désinfecter les tissus ou préserver la texture et la couleur d'origine, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/vue-face-tenue-specialiste-yeux-paires-lunettes-espace-copie_23-2148429596.jpg?w=1800&t=st=1707587004~exp=1707587604~hmac=2939a401810476bb41956eb8c5150a411ad5d196402d67a75b62a307c32eef90"
                    ]],
            ],
            "Linge de maison" => [
                "Literie" => [
                    "Draps" =>[
                        "price"      =>5,
                        "description"=>"Votre drap est bien plus qu'un simple morceau de tissu ; c'est le fondement même d'une bonne nuit de sommeil, un havre de confort et de douceur. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et la texture douce de votre drap, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/tissu-tissu-blanc-pour-couture_23-2148827142.jpg?w=1380&t=st=1707587062~exp=1707587662~hmac=223b343bd8feb84794b23a57977d2d74a7b24ab6fa6bb9b214dd0fd1171464a1"
                    ], 
                    "Taies d'oreiller" => [
                        "price"      =>5,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque taie d'oreiller avec le plus grand soin. Que ce soit pour éliminer les taches, rafraîchir les couleurs ou préserver la texture délicate du tissu, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/oreiller-canape_74190-1320.jpg?w=1380&t=st=1707587132~exp=1707587732~hmac=a782fcdafb2e3d36a234fe96fc3219f69c365e51e9774a689fc923ef210a2668"
                    ], 
                    "Housses de couette" =>[
                        "price"      =>8,
                        "description"=>"Vos housses de couette sont l'élément central de votre literie, ajoutant une touche de style et de confort à votre chambre à coucher. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et la douceur de vos housses de couette, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/chambre-double-realiste-mobilier-grandes-fenetres_176382-285.jpg?w=1060&t=st=1707587270~exp=1707587870~hmac=9caf600a1f7c025a019d6d3172c1210559f60b9ca654120f2393c87aa2dde4c5"
                    ], 
                    "Housses d'oreiller" => [
                        "price"      =>2,
                        "description"=>"Vos housses d'oreiller ajoutent une touche de confort et d'élégance à votre literie, tout en protégeant vos oreillers des taches et de l'usure quotidienne. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et la douceur de vos housses d'oreiller, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/point-mise-au-point-selective-oreiller-dans-chambre_74190-1777.jpg?w=1380&t=st=1707587302~exp=1707587902~hmac=cf2cce59d66d64395149cb960d21b515aa0056eb8a4cc5a601faa0c50503dc63"
                    ], 
                    "Plaids" => [
                        "price"      =>8,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque taie d'oreiller avec le plus grand soin. Que ce soit pour éliminer les taches, rafraîchir les couleurs ou préserver la texture délicate du tissu, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/couverture-blanche-tissee-canape_53876-133350.jpg?w=1380&t=st=1707587383~exp=1707587983~hmac=ce8256d63a84d2daa864b17520c7e1fa8ebc707c7d273c9a93abc2dbb53a9cd0"
                    ], 
                    "Couettes" =>[
                        "price"      =>12,
                        "description"=>"Votre couette est l'essence même du confort et de la chaleur pour des nuits de sommeil paisibles et réparatrices. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et la douceur de votre couette, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/couette-rabattable_53876-133357.jpg?w=1380&t=st=1707587684~exp=1707588284~hmac=33fc6382aabdbccab00ec6dbe985b43f96a5e99035b8c1910d832da004368041"
                    ], 
                    "Coussins" => [
                        "price"      =>8,
                        "description"=>"Vos coussins sont bien plus que de simples accessoires de décoration ; ils sont les compagnons de vos moments de détente et de confort à la maison. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et le moelleux de vos coussins, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/oreiller-doux-blanc_176382-1116.jpg?w=900&t=st=1707587668~exp=1707588268~hmac=c4aee2f85d97bfa506a2110b1764ca0463c2d14da76b269fa47a7acc89c5743a"
                    ]],
                "Serviettes" => [
                    "Serviettes de bain" => [
                        "price"      =>5,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque serviette de bain avec le plus grand soin. Que ce soit pour éliminer les taches, rafraîchir les couleurs ou préserver la douceur du tissu, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/savon-serviette_23-2147999947.jpg?w=1380&t=st=1707587832~exp=1707588432~hmac=d9cc710d58cf5b2831ed3b62b2965e65aa14e2d6cbce28467a4881eb9f8ecd5e"
                    ], 
                    "Serviettes de toilette" => [
                        "price"      =>2,
                        "description"=>"Notre équipe de professionnels du pressing est formée pour traiter chaque serviette de toilette avec le plus grand soin. Que ce soit pour éliminer les taches, rafraîchir les couleurs ou préserver la texture du tissu, nous utilisons des techniques avancées pour garantir un résultat impeccable à chaque fois.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/serviettes-blanches-empilees_23-2147999886.jpg?w=1380&t=st=1707588002~exp=1707588602~hmac=315929cd71bc45c8ee7952026d2feb7a8501f196e921e3eb4565b73f5043d093"
                    ]],
                "Cuisine" => [
                    "Nappes" => [
                        "price"      =>5,
                        "description"=>"Votre nappe est bien plus qu'un simple revêtement de table ; c'est le centre de l'attention lors des repas en famille, des dîners entre amis et des occasions spéciales. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et l'élégance de votre nappe, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/maquette-table-manger-vide-tissu-blanc-chaises-bois_176382-1941.jpg?w=740&t=st=1707588048~exp=1707588648~hmac=f692e83a4622fa3f9e75ace84aad4fbaabadd390024b7a191f189c9a30843688"
                    ], 
                    "Sets de table" => [
                        "price"      =>2,
                        "description"=>"Vos sets de table ajoutent une touche d'élégance et de style à votre table à manger, protégeant en même temps la surface des éclaboussures et des taches. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et l'apparence de vos sets de table, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/vaisselle-fourchette-serviette_176382-1585.jpg?w=740&t=st=1707588088~exp=1707588688~hmac=ffbd7240202174252bad3d384fd792f3ac449d63384cfbc174599c3fb428e20b"
                    ], 
                    "Serviettes de cuisine" => [
                        "price"      =>2,
                        "description"=>"Vos serviettes de cuisine sont des compagnons indispensables dans votre espace culinaire, vous offrant à la fois praticité et style. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et l'efficacité de vos serviettes de cuisine, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/epinards-table_144627-20717.jpg?w=740&t=st=1707588155~exp=1707588755~hmac=165b8869d24ef05da838ee82bcce9647f0ec0edb8222c293d2fb199b8bef8bb6"
                    ], 
                    "Tabliers" => [
                        "price"      =>3,
                        "description"=>"Votre tablier de cuisine est bien plus qu'un simple accessoire ; c'est un symbole de passion, de créativité et de savoir-faire culinaire. Chez nous, nous comprenons l'importance de préserver la fraîcheur, la propreté et le style de votre tablier de cuisine, c'est pourquoi nous offrons un service de pressing spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/tablier-blanc-simple-poches_53876-106022.jpg?w=740&t=st=1707588189~exp=1707588789~hmac=2483d7f6f5c5a50937327b5dcab185f788dc194ca9e3bf27f3306b0d97ab06f6"
                    ]],
                "Rideaux" => [
                    "Rideau(<100x200)" => [
                        "price"      =>5,
                        "description"=>"Vos rideaux contribuent à créer une atmosphère chaleureuse et accueillante dans votre maison, tout en offrant fonctionnalité et esthétique. Notre service de pressing spécialisé assure un traitement adapté à vos rideaux, afin qu'ils restent toujours prêts à embellir votre intérieur et à vous offrir confort et style.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/toile-fond-produit-rideau-blanc_53876-134414.jpg?size=626&ext=jpg&ga=GA1.1.154618317.1700647714&semt=sph"
                    ],
                    "Rideau(140x200)" => [
                        "price"      =>8,
                        "description"=>"Vos rideaux contribuent à créer une atmosphère chaleureuse et accueillante dans votre maison, tout en offrant fonctionnalité et esthétique. Notre service de pressing spécialisé assure un traitement adapté à vos rideaux, afin qu'ils restent toujours prêts à embellir votre intérieur et à vous offrir confort et style.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/toile-fond-produit-rideau-blanc_53876-134414.jpg?size=626&ext=jpg&ga=GA1.1.154618317.1700647714&semt=sph"
                    ], 
                    "Rideau(200x280)"=> [
                        "price"      =>10,
                        "description"=>"Vos rideaux contribuent à créer une atmosphère chaleureuse et accueillante dans votre maison, tout en offrant fonctionnalité et esthétique. Notre service de pressing spécialisé assure un traitement adapté à vos rideaux, afin qu'ils restent toujours prêts à embellir votre intérieur et à vous offrir confort et style.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/toile-fond-produit-rideau-blanc_53876-134414.jpg?size=626&ext=jpg&ga=GA1.1.154618317.1700647714&semt=sph"
                    ]],
            ],
            "Chaussures" => [
                "Chaussures de ville " => [
                    "Tongs"=> [
                        "price"      =>2,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/sandales-blanches-simples-mode-chaussures-ete_53876-106049.jpg?w=740&t=st=1707588439~exp=1707589039~hmac=105e164963e407bc885ac385dbd4eb7f31c54144cacc5e08e3f74e87cae4b2c3"
                    ], 
                    "Sandales" => [
                        "price"      =>5,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ], 
                    "Derbies" => [
                        "price"      =>8,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/derbies-homme-cuir-marron_53876-97144.jpg?w=1380&t=st=1707588537~exp=1707589137~hmac=772f0fd555c791092526876278ede20bf54ea343b37ee3125517790574bea33c"
                    ], 
                    "Bottes" => [
                        "price"      =>8,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/bottes-cuir_1203-8122.jpg?w=740&t=st=1707588596~exp=1707589196~hmac=e93d8ad14d7e1acefb965dd3f0277017a0c17b9693667f5cb2d759c4a3191d4d"
                    ], 
                    "Bottines" => [
                        "price"      =>10,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?q=80&w=1780&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ]],
                "Chaussures de sport" => [
                    "Sneakers" =>[
                        "price"      =>5,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/chaussures-baskets-mode_1203-7529.jpg?w=1380&t=st=1707588731~exp=1707589331~hmac=8da1615e19d794129955f4ce23034b469f7d6bacc570ce500fbadc5b3fdcad54"
                    ], 
                    "Chaussures sport pro" => [
                        "price"      =>8,
                        "description"=>"Vos chaussures sont bien plus que de simples articles de mode ; elles sont le reflet de votre style, de votre confort et de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de vos chaussures, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=1760&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    ]],   
            ],
            "Accessoires" => [
                "Accessoires" => [
                    "Sacs à main"=> [
                        "price"      => 6,
                        "description"=>"Votre sac à main est bien plus qu'un accessoire de mode ; il est le gardien de vos essentiels, l'expression de votre style et le compagnon de vos aventures quotidiennes. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de votre sac à main, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/main-mode-texture-cuir-poignee_1203-6503.jpg?w=1380&t=st=1707588964~exp=1707589564~hmac=035a9142db9a90bac4186335e22d0579346a26ce4dee728cf71b2f6431c88f5c"
                    ], 
                    "Chapeaux"=> [
                        "price"      => 5,
                        "description"=>"Votre chapeau est bien plus qu'un simple accessoire de mode ; c'est une déclaration de style, une protection contre les éléments et une expression de votre personnalité. Chez nous, nous comprenons l'importance de préserver la qualité, la forme et l'aspect de votre chapeau, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/chapeau-fedora-mode-studio_23-2150744030.jpg?w=1380&t=st=1707589028~exp=1707589628~hmac=bd54dfe4778c3818f5344f6ff962918bc7935ef48f1dd7a6b44757de8a21501f"
                    ], 
                    "Ceintures"=> [
                        "price"      => 3,
                        "description"=>"Votre ceinture est bien plus qu'un accessoire de mode ; il est le gardien de vos essentiels, l'expression de votre style et le compagnon de vos aventures quotidiennes. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de votre ceinture, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/psd-gratuit/ceinture-roulee-interieur-boite-blanche_176382-1579.jpg?w=740&t=st=1707589064~exp=1707589664~hmac=bdd1886438c6143ba21ac094dd24b0d75a10b3afe4da288b8d53caeaf72d79d0"
                    ], 
                    "Echarpes" => [
                        "price"      => 3,
                        "description"=>"Votre écharpe est bien plus qu'un accessoire de mode ; il est le gardien de vos essentiels, l'expression de votre style et le compagnon de vos aventures quotidiennes. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de votre écharpe, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/echarpe-hiver-bleu_1101-502.jpg?1&w=900&t=st=1707589159~exp=1707589759~hmac=d9bfde7daaf940cc428a79328686b6766670f82ea7b2cd9276fcc2fd5118ba07"
                    ], 
                    "Foulard" => [
                        "price"      => 5,
                        "description"=>"Votre foulard est bien plus qu'un accessoire de mode ; il est le gardien de vos essentiels, l'expression de votre style et le compagnon de vos aventures quotidiennes. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de votre foulard, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/mouchoir-texture-lisse-suspendu_23-2149091390.jpg?w=740&t=st=1707589238~exp=1707589838~hmac=68dad09ab5515eec714aed4cfc7eced8f371e2f4715f15ef881b89cfcd30dbbd"
                    ], 
                    "Cravate" => [
                        "price"      => 5,
                        "description"=>"Votre cravate est bien plus qu'un accessoire de mode ; il est le gardien de vos essentiels, l'expression de votre style et le compagnon de vos aventures quotidiennes. Chez nous, nous comprenons l'importance de préserver la qualité, la propreté et l'aspect de votre cravate, c'est pourquoi nous offrons un service de nettoyage et de soin spécialisé.",
                        "imagePath"  => "https://img.freepik.com/photos-gratuite/vue-dessus-liens-fond-bois_23-2148510752.jpg?w=1380&t=st=1707589301~exp=1707589901~hmac=642a13e3f1611065d04552ef60ecf8292168e20040aee7cf29389998e2a0adbc"
                    ]],
            ],
        ];

        // boucle catégorie parent
        $dbProducts=[];
        foreach ($mainCategories as $mainCategoryName => $subCategories) {
            $mainCategory = new Category();
            $mainCategory->setName($mainCategoryName);
            $manager->persist($mainCategory);
            //  boucle sous-catégorie
            foreach ($subCategories as $subCategoryName => $products) {
                $subCategory = new Category();
                $subCategory->setName($subCategoryName);
                $manager->persist($subCategory);
                //  Produits
                foreach ($products as $productName=>$productData) {
                    $product = new Product();
                    $product
                        ->setName($productName)
                        ->setPrice($productData['price'])
                        ->setDescription($productData['description'])
                        ->setProductStatus($faker->randomElement($allProductStatus))
                        ->setImagePath($productData['imagePath']);
                    $subCategory->addProduct($product);
                    $manager->persist($product);
                    $dbProducts[]=$product;
                }
                $mainCategory->addChild($subCategory);

            }
            $manager->persist($mainCategory);
        }

        // matériel
        $materialInfos = [
            [
                "name" => "Coton",
                "coefficentPrice" => 0.1
            ],
            [
                "name" => "Lin",
                "coefficentPrice" => 0.2
            ],
            [
                "name" => "Laine",
                "coefficentPrice" => 0.3
            ],
            [
                "name" => "Polytester",
                "coefficentPrice" => 0.1
            ],
            [
                "name" => "Soie",
                "coefficentPrice" => 0.5
            ],
            [
                "name" => "Denim",
                "coefficentPrice" => 0.2
            ],

        ];

        $allMaterials = [];
        foreach ($materialInfos as $materialInfo) {
            $material = new Material();
            $material->setName($materialInfo["name"])
            ->setCoefficentPrice($materialInfo['coefficentPrice']);
            $manager->persist($material);    
            $allMaterials[] = $material;
        }

        //service options
        $serviceInfos = [
            [
                "name" => "Lavage",
                "coefficentPrice" => 0
            ],
            [
                "name" => "Repassage",
                "coefficentPrice" => 0.1
            ],
            [
                "name" => "Nettoyage à sec",
                "coefficentPrice" => 0.3
            ],
            [
                "name" => "Blanchiment",
                "coefficentPrice" => 0.1
            ],
            [
                "name" => "Détachement ",
                "coefficentPrice" => 0.2
            ],
            [
                "name" => "Retouche",
                "coefficentPrice" => 0.2
            ],  
        ];

        $allServices = [];
        foreach ($serviceInfos as $service) {
            $serviceOption = new ServiceOption();
            $serviceOption
                ->setName($service["name"])
                ->setCoefficentPrice($service["coefficentPrice"]);

            $manager->persist($serviceOption);
            $allServices[] = $serviceOption;
        }

        // produits sélectionnés
        $priceCalculator = new PriceCalculator();
        $orderDetails = [];
        for ($i = 0; $i < UserFixtures::NB_ORDERS; $i++) {
            $orderDetails[] = $this->getReference(UserFixtures::ORDER_DETAIL_PREFIX . $i);
        }

        $allProductSelected = [];
        for ($i = 0; $i < self::NB_PRODUCT_SELECTED; $i++) {
            $productSelected = new ProductSelected();
            $product = $faker->randomElement($dbProducts);
            $productSelected->setProduct($product)
                ->setMaterial($faker->randomElement($allMaterials))
                ->setOrderDetail($faker->randomElement($orderDetails))
                ->setQuantity($faker->numberBetween(0, 7));

            $nbServices = $faker->numberBetween(1, 3);
            $servicesSelected = [];
            for ($j = 0; $j < $nbServices; $j++) {
                $servicesSelected[] = $faker->randomElement($allServices);

            }

            $totalPrice = $priceCalculator->calculateTotalPrice($product, $servicesSelected);
            $productSelected->setTotalPrice($totalPrice);

            foreach ($servicesSelected as $service) {
                $productSelected->addServiceOption($service);
                $manager->persist($service);
            }
            $manager->persist($productSelected);
            $allProductSelected[] = $productSelected;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
