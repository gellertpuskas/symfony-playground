<?php

namespace App\Entity;

class Topping
{
    private string $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    private string $name;

    public function getName() {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}
