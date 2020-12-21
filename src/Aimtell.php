<?php

namespace Collinped\LaravelAimtell;

use Collinped\Aimtell\Aimtell as SourceAimtell;
use Illuminate\Support\Traits\Macroable;

class Aimtell extends SourceAimtell
{
    use Macroable {
        Macroable::__call as macroCall;
    }

    public function __call(string $method, array $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }
    }
}
