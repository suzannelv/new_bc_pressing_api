<?php 


namespace App\DataFixtures;
use App\Entity\Client;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
  public function load(ObjectManager $manager):void
  {

    $faker= Factory::create("fr_FR");

    $client = new Client();
    $client->setEmail('test@gmail.com')
           ->setPassword("123456")
           ->setFirstname("Daniel")
           ->setLastname('Griffin')
           ->setBirthday(DateTimeImmutable::createFromFormat('d-m-Y', '01-01-1990'))
           ->setPhoneNumber('0666666666')
           ->setAdress($faker->address())
           ->setCreatedAt(DateTimeImmutable::createFromFormat('d-m-Y', '01-01-2022'))
           ->setMembership(true);
    $manager->persist($client);

    $manager->flush();

  }

  
}