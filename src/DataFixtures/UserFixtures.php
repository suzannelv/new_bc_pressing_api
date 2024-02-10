<?php


namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Employee;
use App\Entity\OrderDetail;
use App\Entity\OrderStatus;
use App\Entity\Payment;
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
  public function load(ObjectManager $manager): void
  {

    $faker = Factory::create("fr_FR");
    // pays
    $country = new Country();
    $country->setCountry("France");
    $manager->persist($country);

    // code postale et ville
    $zipCodes = [];
    for ($i = 0; $i < self::NB_ZIPCODE; $i++) {
      $zipCode = new ZipCode();
      $zipCode->setCity($faker->city())
        ->setZipCode($faker->postcode())
        ->setCountry($country);
      $manager->persist($zipCode);
      $zipCodes[] = $zipCode;
    }
    // clients
    $clients = [];
    for ($i = 0; $i < self::NB_CLIENT; $i++) {
      $client = new Client();
      $client->setEmail($faker->email())
        ->setPassword("123456")
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setBirthday($faker->dateTimeBetween('-30 years', 'now'))
        ->setPhoneNumber('0666666666')
        ->setAdress($faker->address())
        ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 years')))
        ->setClientNumber($faker->numerify('clt-######'))
        ->setZipCode($faker->randomElement($zipCodes));
      $manager->persist($client);
      $clients[] = $client;
    }


    // employées
    $emps = [];
    for ($i = 0; $i < self::NB_EMP; $i++) {
      $emp = new Employee();
      $emp->setEmail($faker->email())
        ->setPassword("123456")
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setBirthday($faker->dateTimeBetween('-30 years', 'now'))
        ->setPhoneNumber('0666666666')
        ->setAdress($faker->address())
        ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 years')))
        ->setEmpNumber($faker->numerify('emp-######'))
        ->setAdminRole($faker->boolean(10))
        ->setZipCode($faker->randomElement($zipCodes));
      $manager->persist($emp);
      $emps[] = $emp;
    }

    // mode de payment
    $paymentMethods = [];
    for ($i = 0; $i < self::NB_PAY_METHODE; $i++) {
      $payment = new Payment();

      $payment->setMethod($faker->creditCardType());
      $manager->persist($payment);
      $paymentMethods[] = $payment;
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
        ->setPayment($faker->randomElement($paymentMethods))
        ->setEmp(!empty($emps) ? $faker->randomElement($emps) : null)
        ->setClient(!empty($clients) ? $faker->randomElement($clients) : null)
        ->setOrderStatus($faker->randomElement($orderStatusList));
      $manager->persist($orderDetail);
      $this->addReference(self::ORDER_DETAIL_PREFIX . $i, $orderDetail);
    }

    $manager->flush();
  }
}