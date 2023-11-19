<?php

namespace Laravia\Domparser\Tests\Unit\App\Orchid\Screens;

use Laravia\Heart\App\Classes\TestCase;
use Laravia\Heart\App\Classes\TestScreenCaseTrait;
use Laravia\Domparser\App\Orchid\Screens\DomparserScreen;

class DomparserScreenTest extends TestCase
{

    use TestScreenCaseTrait;
    public function getScreenTestClass()
    {
        return new DomparserScreen();
    }

}
