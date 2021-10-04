<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController {

    /** @var UserRepository */
    private $userRepository;

    /** @var ValidatorInterface */
    private $validator;

    /** @var UserPasswordHasherInterface  */
    private $userPasswordHasher;

    public function __construct(UserRepository $userRepository, ValidatorInterface $validator, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function index() {
        $users = $this->userRepository->findAll();
        return $this->render("user/index.html.twig", [ "users" => $users ]);
    }

    public function create(Request $request) {
        $user = new User();
        $user->setEmail("example@gmail.com");

        $userForm = $this->createForm(UserType::class, $user, [
            "action" => $this->generateUrl("user_create"),
            "method" => "POST"
        ]);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted()) {
            $result = $this->store($userForm);

            return $this->redirectToRoute("pizza_index"); // TODO success
        }

        return $this->renderForm("user/create.html.twig", [
            "form" => $userForm
        ]);
    }

    private function store(FormInterface $form) {
        $errors = $this->validator->validate($form);
        if(count($errors) !== 0)
        {
            return [
                "success" => false,
                "user" => null
            ];
        }

        $em = $this->getDoctrine()->getManager();

        $user = $form->getData();

        $hashed_password = $this->userPasswordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashed_password);

        $em->persist($user);
        $em->flush();

        return [
            "success" => true,
            "pizza" => $user
        ];
    }
}