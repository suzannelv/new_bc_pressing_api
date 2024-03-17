<?php 

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ClientController extends AbstractController
{

  public function __construct(private Security $security){}

  #[Route('/api/me', name: 'get_current_client', methods: ['GET'])]
  public function getCurrentClient():JsonResponse
  {
    $user = $this->security->getUser();
    if(!$user && !$user instanceof Client){
      return $this->json(['message' => 'Client non trouvé'], JsonResponse::HTTP_FORBIDDEN);
    }

    $clientData = [
     'id'         =>$user->getId(),
     'clientNumber' => $user->getClientNumber(),
     'email'      =>$user->getEmail(), 
     'firstname'  =>$user->getFirstname(),
     'lastname'   =>$user->getLastname(),
     'phoneNumber'=>$user->getPhoneNumber(),
     'adress'     =>$user->getAdress(),
     'zipCodeIRI' =>$user->getZipCode(),
     'zipCode'    =>[
        'zipCode'=>$user->getZipCode()->getZipCode(),
        'city'=>$user->getZipCode()->getCity()
     ],
    ];

    return $this->json($clientData);
  }

}