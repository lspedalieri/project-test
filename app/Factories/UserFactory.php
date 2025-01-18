<?php

declare(strict_types=1);

namespace App\Factories;

use App\Entities\UserEntity;
use App\Models\User as UserModel;

class UserFactory
{
    public static function fromModel(UserModel $user): UserEntity
    {
        return new UserEntity(
            $user->id,
            $user->email,
            $user->name,
        );
    }
}
