<?php

namespace Laravia\Domparser\Tests\Unit\App\Orchid\Layouts;

use Laravia\Domparser\App\Orchid\Layouts\DomparserListLayout;
use Laravia\Heart\App\Classes\TestCase;

class DomparserListLayoutTest extends TestCase
{

    public $class = 'Laravia\Domparser\App\Orchid\Layouts\DomparserListLayout';

    public function testInitClass()
    {
        $this->assertClassExist($this->class);
    }

    public function testColumnsExist()
    {
        $this->assertMethodInClassExists('columns', DomparserListLayout::class);
    }
    public function testColumns()
    {
        $this->assertIsArray((new DomparserListLayout)->columns());
    }
}
