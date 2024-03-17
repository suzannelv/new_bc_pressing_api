<?php 

namespace App\Utils;
use App\Entity\Product;

class PriceCalculator
{
  public function calculateTotalPrice(Product $product, array $selectedServices):float
{
    $productPrice = $product->getPrice();
    $serviceTotalPrice = 0;

    foreach($selectedServices as $serviceOption){
      $serviceTotalPrice += $productPrice * $serviceOption->getCoefficentPrice();
    }

    $totalPrice = $productPrice + $serviceTotalPrice;
    return $totalPrice;
}
}  