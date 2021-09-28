<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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

        $pizza_form = $this->createForm(PizzaType::class, $pizza, [
            "action" => $this->generateUrl("pizza_create"),
            "method" => "POST"
        ]);

        $pizza_form->handleRequest($request);

        if($pizza_form->isSubmitted() && $pizza_form->isValid())
        {
            $this->store($pizza_form);

            return $this->redirectToRoute("pizza_index"); // TODO success
        }

        return $this->renderForm("pizza/create.html.twig", [
            "form" => $pizza_form
        ]);
    }

    private function store(FormInterface $pizza_form)
    {
        $doctrine = $this->getDoctrine();

        $entityManager = $doctrine->getManager();

        $pizza = $pizza_form->getData();

        $entityManager->persist($pizza);

        $entityManager->flush();
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
}