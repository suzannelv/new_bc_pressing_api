<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(
        private RouterInterface $router, 
        private Security $security){
        }

    #[Route(path: '/connexion', name: 'app_login', methods:['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($this->getUser()) {
            if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_EMPLOYEE')) {
                return new RedirectResponse($this->router->generate('app_admin'));
            }
        }
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/deconnextion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/inscription', name: 'app_register')]
    public function registration(Request $request, EntityManagerInterface $manager):Response
    {
        $emp = new Employee();
        $emp->setRoles(['ROLE_EMPLOYEE']);
        $form = $this->createForm(RegisterType::class, $emp);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
            $emp = $form->getData();
            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );

            $manager->persist($emp);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
