<?php


namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Employee;
use App\Entity\OrderDetail;
use App\Entity\OrderStatus;
use App\Entity\Payment;
use App\Entity\User;
use App\Entity\ZipCode;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
  private const NB_ZIPCODE = 5;
  private const NB_CLIENT = 20;
  private const NB_EMP = 6;
  private const NB_PAY_METHODE = 3;
  public const NB_ORDERS = 10;
  public const ORDER_DETAIL_PREFIX = 'orderDetailList_';

  public function __construct(private string $adminEmail){}
  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create("fr_FR");
    // pays
    $country = new Country();
    $country->setCountry("France");
    $manager->persist($country);

    // code postale et ville
 
    $zipCodesData = [
      ['city'=> 'Lyon', 'zipCode'=>'69001'],
      ['city'=> 'Lyon', 'zipCode'=>'69002'],
      ['city'=> 'Lyon', 'zipCode'=>'69003'],
      ['city'=> 'Lyon', 'zipCode'=>'69004'],
      ['city'=> 'Lyon', 'zipCode'=>'69005'],
      ['city'=> 'Lyon', 'zipCode'=>'69006'],
      ['city'=> 'Lyon', 'zipCode'=>'69007'],
      ['city'=> 'Lyon', 'zipCode'=>'69008'],
      ['city'=> 'Lyon', 'zipCode'=>'69009'],
      ['city'=> 'Villeurbanne', 'zipCode'=>'69100'],
      ['city'=> 'Vaulx-en-Velin', 'zipCode'=>'69120'],
      ['city'=> 'Écully', 'zipCode'=>'69130'],
      ['city'=> 'Bron', 'zipCode'=>'69500'],
      ['city'=> 'Tassin-la-Demi-Lune', 'zipCode'=>'69160'],
      ['city'=> 'Décine-Charpieu', 'zipCode'=>'69275'],
      ['city'=> 'Vénissieux', 'zipCode'=>'69275'],
      ['city'=> 'Caluire-et-Cuire ', 'zipCode'=>'69034'],
    ];

    $zipCodes = [];
    foreach($zipCodesData as $data) {
      $zipCode = new ZipCode();
      $zipCode ->setZipCode($data['zipCode'])
               ->setCity($data['city'])
               ->setCountry($country);
      $manager->persist($zipCode);
      
      $zipCodes[] = $zipCode; 
    }

    // clients
    $clients = [];
    for ($i = 0; $i < self::NB_CLIENT; $i++) {
      $client = new Client();
      $randomZipCode = $faker->randomElement($zipCodes);
      $client->setEmail($faker->email())
        ->setPassword("123456")
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setBirthday($faker->dateTimeBetween('-30 years', 'now'))
        ->setPhoneNumber('0666666666')
        ->setAdress($faker->address())
        ->setRoles(['ROLE_CLIENT'])
        ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 years')))
        ->setClientNumber($faker->numerify('clt-######'))
        ->setZipCode($randomZipCode);
      $manager->persist($client);
      $clients[] = $client;
    }

    // administrateur
    $admin = new User();
    $admin->setFirstname("Bernard")
          ->setLastname("Shabi")
          ->setEmail($this->adminEmail)
          ->setRoles(['ROLE_ADMIN'])
          ->setPhoneNumber('0462854136')
          ->setPassword("admin123456")
          ->setAdress('1 Rue République')
          ->setZipCode($randomZipCode)
          ->setCreatedAt(new DateTimeImmutable('2020-01-01'))
          ->setBirthday(new DateTimeImmutable('1980-02-16'));
    $manager->persist($admin);

    // employées
    $emps = [];
    for ($i = 0; $i < self::NB_EMP; $i++) {
      $emp = new Employee();
      $randomZipCode = $faker->randomElement($zipCodes);
      $emp->setEmail($faker->email())
        ->setPassword("123456")
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setBirthday($faker->dateTimeBetween('-30 years', 'now'))
        ->setPhoneNumber('0666666666')
        ->setAdress($faker->address())
        ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 years')))
        ->setRoles(['ROLE_EMPLOYEE'])
        ->setEmpNumber($faker->numerify('emp-######'))
        ->setAdminRole($faker->boolean(10))
        ->setZipCode($randomZipCode);
      $manager->persist($emp);
      $emps[] = $emp;
    }

    // mode de payment

    $paymentMethods = [
     ['method'=> "Paypal", "icon"=>'fa-brands fa-cc-paypal fs-5'],
     ['method'=> "Visa", "icon"=>'fa-brands fa-cc-visa fs-5'],
     ['method'=> "MasterCard", "icon"=>'fa-brands fa-cc-mastercard fs-5'],
     ['method'=> "Paiement en boutique", "icon"=>'fa-solid fa-cash-register fs-5'],
    ];
    $paymentEntities = []; 
    foreach ($paymentMethods as $methodData) {
      $payment = new Payment();
      $payment->setMethod($methodData['method'])
              ->setIcon($methodData['icon']);
  
      $manager->persist($payment);
      $paymentEntities[] = $payment; 
  }
  
    // status de commande

    $orderStatusNames = ["En attente de traitement", "En cours de traitement", "En attente de paiement", "Prête pour la collecte", "En cours de livraison", "Livré", "Annulé"];
    $orderStatusList = [];
    foreach ($orderStatusNames as $statusName) {
      $orderStatus = new OrderStatus();
      $orderStatus->setStatus($statusName);

      $manager->persist($orderStatus);
      $orderStatusList[] = $orderStatus;

    }


    // commande info

    for ($i = 0; $i < self::NB_ORDERS; $i++) {
      $orderDetail = new OrderDetail();
      $orderDetail->setOrderNumber($faker->regexify('[A-Z]{5}[0-4]{3}'))
        ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 week', 'now')))
        ->setDelivery($faker->boolean(50))
        ->setDepositDate(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 week', 'now')))
        ->setRetrieveDate(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now', '+1 week')))
        ->setPayment($faker->randomElement($paymentEntities))
        ->setEmp(!empty($emps) ? $faker->randomElement($emps) : null)
        ->setClient(!empty($clients) ? $faker->randomElement($clients) : null)
        ->setOrderStatus($faker->randomElement($orderStatusList));
      $manager->persist($orderDetail);
      $this->addReference(self::ORDER_DETAIL_PREFIX . $i, $orderDetail);
    }

    $manager->flush();
  }
}