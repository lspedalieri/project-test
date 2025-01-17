<?php

declare(strict_types=1);

namespace App\Factories;

use App\Domain\Users\Entities\User;
use App\Models\User as UserModel;

class UserFactory
{
    public static function fromModel(UserModel $user): User
    {
        return new User(
            $user->id,
            $user->email,
            $user->name,
        );
    }
}
