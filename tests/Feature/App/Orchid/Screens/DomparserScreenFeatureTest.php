<?php

namespace Laravia\Domparser\Tests\Feature\App\Orchid\Screens;

use Laravia\Heart\App\Classes\TestCase;

class DomparserScreenFeatureTest extends TestCase
{

    public function test_domparser_screen_can_be_rendered()
    {
        $this->actAsAdmin();
        $response = $this->get(route('laravia.domparser.list'));
        $response->assertOk();
    }

}
