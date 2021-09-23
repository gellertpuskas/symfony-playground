<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PizzaController extends AbstractController
{
    public final function index(PizzaRepository $pizzaRepository)
    {
        $pizzas = $pizzaRepository->findAll();

        return $this->json($pizzas);
    }

    public final function store() {
        $entityManager = $this->getDoctrine()->getManager();

        $pizza = new Pizza();
        $pizza->setName("test pizza");

        $entityManager->persist($pizza);
        $entityManager->flush();

        return $this->json($pizza);
    }
}