<?php

namespace App\Service;
use App\Entity\ZipCode;
use App\Repository\ZipCodeRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService 
{
  public function __construct(
    private EntityManagerInterface $em, 
    private ZipCodeRepository $zipCodeRepository){} 
  
  public function registerUser(array $userData){
    $zipValue = $userData['zipCodeValue'];
    $zipCode = $this->zipCodeRepository->findOneBy(['zipCode'=>$zipValue]);

    if(!$zipCode){
      $zipCode = new ZipCode();
      $zipCode->setZipCode($zipValue);
    }
  }


}