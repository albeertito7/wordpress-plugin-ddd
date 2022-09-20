<?php

namespace Entities\Unit;

use Entities\Controllers\MasterController;
use PHPUnit\Framework\TestCase;

final class MasterControllerTest extends TestCase
{
    /** @test */
    public function silenceIsGolden(): void
    {
        $expected = 'Silence is golden';
        $this->expectOutputString($expected);

        $instance = new MasterController();
        $instance->ajax();
    }
}
