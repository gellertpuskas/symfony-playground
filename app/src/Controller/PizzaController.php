<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PizzaController extends AbstractController
{
    public final function index(PizzaRepository $pizzaRepository)
    {
        $pizzas = $pizzaRepository->findAll();

        return $this->render("pizza_index.html.twig", [
            "pizzas" => $pizzas
        ]);
    }

    public final function create(Request $request)
    {
        $pizza = new Pizza();
        $pizza->setName("Pizza name");
        $pizza->setPrice(1000);

        $pizza_form = $this->createForm(PizzaType::class, $pizza);

        $pizza_form->handleRequest($request);

        if($pizza_form->isSubmitted() && $pizza_form->isValid())
        {
            $pizza = $pizza_form->getData();
            return $this->redirectToRoute("pizza_index"); // TODO success
        }

        return $this->renderForm("pizza/create.html.twig", [
            "form" => $pizza_form
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