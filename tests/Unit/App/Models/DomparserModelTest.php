<?php

namespace Laravia\Domparser\Tests\Unit\App;

use Laravia\Domparser\App\Models\Domparser;
use Laravia\Heart\App\Classes\TestCase;

class DomparserModelTest extends TestCase
{
    public function testInitClass()
    {
        $this->assertClassExist(Domparser::class);
    }

    public function testCreateDomparser()
    {
        $url = $this->faker->url;
        $element = $this->faker->word;
        $cronjob = "* * * * *";
        $email = $this->faker->email;
        $unique = true;

        Domparser::create([
            'url' => $url,
            'element' => $element,
            'cronjob' => $cronjob,
            'email' => $email,
            'unique' => $unique,
        ]);

        $this->assertDatabaseHas('domparsers', [
            'url' => $url,
            'element' => $element,
            'cronjob' => $cronjob,
            'email' => $email,
            'unique' => $unique,
        ]);
    }
}
