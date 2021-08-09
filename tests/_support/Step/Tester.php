<?php

namespace Step;

use ApiTester;

class Tester extends ApiTester
{
    /**
     * @param array $sides
     *
     * @return void
     */
    public function sendTriangleSides(array $sides = []): void
    {
        $this->sendGet('/triangle/possible',  $sides);
    }
}
