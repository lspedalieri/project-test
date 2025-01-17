<?php

declare(strict_types=1);

namespace App\Domain\Product\Exceptions;

use Exception;
use Throwable;

class OrderNotFoundException extends Exception
{
    public function __construct(int $id, ?Throwable $previous = null)
    {
        parent::__construct("The order with ID {$id} was not found,", 0, $previous);
    }
}
