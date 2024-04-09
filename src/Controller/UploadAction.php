<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


#[AsController]
final class UploadAction extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductStatusRepository $productStatusRepository
    ) {}

    public function __invoke(Request $request): Product
    {
        $uploadImage = $request->files->get('imageFile');

        $data = $request->request->all();

        if (!$uploadImage instanceof UploadedFile) {
            throw new BadRequestHttpException("La photo du produit est obligatoire");
        }

        $product = new Product();

        $categories = $this->categoryRepository->findAll();
        $statuses = $this->productStatusRepository->findAll();

        $product
            ->setName('Bobby')
            ->setDescription('author rising iron powerful memory any show luck heat melted flight prove dull short basic science without today evidence rapidly later girl sudden than')
            ->setPrice(15.6)
            ->setCategory($categories[0])
            ->setProductStatus($statuses[0]);

        $product->imageFile = $uploadImage;
        return $product;
    }
}
