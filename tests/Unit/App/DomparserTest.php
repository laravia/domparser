<?php

namespace Laravia\Domparser\Tests\Unit;

use Laravia\Heart\App\Classes\TestCase;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Laravia\Domparser\App\Domparser;

class DomparserTest extends TestCase
{
    public function testInitClass()
    {
        $this->assertClassExist(Domparser::class);
    }
}
