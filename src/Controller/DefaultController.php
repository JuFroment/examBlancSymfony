<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class DefaultController extends AbstractController
{

    #[Route('/', name: 'default')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
