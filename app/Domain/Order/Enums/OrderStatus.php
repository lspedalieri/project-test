<?php

declare(strict_types=1);

namespace App\Domain\Order\Enums;

use App\Traits\EnumToArray;

enum OrderStatus: string
{
    use EnumToArray;

    case STATUS_SENT = 'sent';
    case STATUS_ORDERED = 'ordered';
    case STATUS_CANCELED = 'canceled';
}
