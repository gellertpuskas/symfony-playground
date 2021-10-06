<?php

namespace App\Bundle\Api\ApiBundle\Controller;

use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    public final function index(PizzaRepository $pizzaRepository)
    {
        $users = $pizzaRepository->findAll();
        return $this->json($users);
    }
}