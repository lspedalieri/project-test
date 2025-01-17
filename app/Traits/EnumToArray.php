<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumToArray
{
  public static function names(): array
  {
    return array_column(self::cases(), 'name');
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
