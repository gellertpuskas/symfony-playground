<?php

namespace App\Bundle\Test\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    public final function index()
    {
        return $this->json(["hello" => "world"]);
    }
}