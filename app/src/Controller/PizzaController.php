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

        return $this->render("pizza_index.html.twig", [
            "pizzas" => $pizzas
        ]);
    }

    public final function lowPricePizzas(PizzaRepository $pizzaRepository, \App\Services\DumpService $dumpService)
    {
        $pizzas = $pizzaRepository->getPizzasWithLowPrice();

        $dumpService->dumpData($pizzas);

        $res = [];

        foreach ($pizzas as $pizza) {
            $res []= ["name" => $pizza->getName()];
        }

        return $this->json($res);
    }

    public final function store() {
        $entityManager = $this->getDoctrine()->getManager();

        $pizza = new Pizza();
        $pizza->setName("test pizza");
        $pizza->setPrice(1200);

        $entityManager->persist($pizza);
        $entityManager->flush();

        return $this->json($pizza);
    }
}