<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PizzaController extends AbstractController
{
    /** @var ValidatorInterface */
    public $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


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

        if($pizza_form->isSubmitted())
        {
            $storeResult = $this->store($pizza_form);

            $success = $storeResult["success"];

            if($success) {
                return $this->redirectToRoute("pizza_index"); // TODO success
            } else {
                return $this->redirectToRoute("pizza_index"); // TODO error
            }
        }

        return $this->renderForm("pizza/create.html.twig", [
            "form" => $pizza_form
        ]);
    }

    private function store(FormInterface $pizza_form)
    {
        $errors = $this->validator->validate($pizza_form->getData());

        if (count($errors) !== 0)
        {
            return [
                "success" => false,
                "pizza" => null
            ];
        }

        $entityManager = $this->getDoctrine()->getManager();

        $pizza = $pizza_form->getData();

        $entityManager->persist($pizza);

        $entityManager->flush();

        return [
            "success" => true,
            "pizza" => $pizza
        ];
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