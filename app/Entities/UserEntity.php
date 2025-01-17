<?php

declare(strict_types=1);

namespace App\Entities;

class UserEntity
{
    public readonly int $id;

    public readonly string $email;

    public readonly string $name;

    public function __construct(
        int $id,
        string $email,
        string $name,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    }
}
