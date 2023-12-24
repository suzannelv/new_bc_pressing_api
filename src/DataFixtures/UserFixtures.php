<?php 


namespace App\DataFixtures;
use App\Entity\Client;
use App\Entity\Country;
use App\Entity\ZipCode;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
  private const NB_ZIPCODE = 5;
  private const NB_EMP = 6;
  public function load(ObjectManager $manager):void
  {

    $faker= Factory::create("fr_FR");
    // pays
    $country = new Country();
    $country->setCountry("France");
    $manager->persist($country);

    // code postale et ville
    $zipCodes = [];
    for($i=0; $i<self::NB_ZIPCODE; $i++){
      $zipCode = new ZipCode();
      $zipCode->setCity($faker->city())
            ->setZipCode($faker->postcode())
            ->setCountry($country);          
      $manager->persist($zipCode);
      $zipCodes[]=$zipCode;
    }
    // clients
    $client = new Client();
    $client->setEmail('test@gmail.com')
           ->setPassword("123456")
           ->setFirstname("Daniel")
           ->setLastname('Griffin')
           ->setBirthday(DateTimeImmutable::createFromFormat('d-m-Y', '01-01-1990'))
           ->setPhoneNumber('0666666666')
           ->setAdress($faker->address())
           ->setCreatedAt(DateTimeImmutable::createFromFormat('d-m-Y', '01-01-2022'))
           ->setMembership(true)
           ->setZipCode($faker->randomElement($zipCodes));
    $manager->persist($client);

    // employées
    

    $manager->flush();

  }

  
}