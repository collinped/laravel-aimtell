<?php

namespace Collinped\LaravelAimtell\Tests;

use Collinped\Aimtell\Aimtell;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @var Aimtell
     */
    protected Aimtell $aimtell;

    public function setUp(): void
    {
        parent::setUp();
        $this->aimtell = aimtell();
    }
}
