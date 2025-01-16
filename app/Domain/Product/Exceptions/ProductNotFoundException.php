<?php

declare(strict_types=1);

namespace App\Domain\Product\Exceptions;

use Exception;
use Throwable;

class ProductNotFoundException extends Exception
{
    public function __construct(int $id, ?Throwable $previous = null)
    {
        parent::__construct("The product with ID {$id} was not found,", 0, $previous);
    }
}
