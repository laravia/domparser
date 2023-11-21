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
        $domparser = Domparser::factory()->make();

        Domparser::create([
            'url' => $domparser->url,
            'filter' => $domparser->filter,
            'searchkey' => $domparser->searchkey,
            'cronjob' => $domparser->cronjob,
            'email' => $domparser->email,
            'unique' => $domparser->unique,
        ]);

        $this->assertDatabaseHas('domparsers', [
            'url' => $domparser->url,
            'filter' => $domparser->filter,
            'searchkey' => $domparser->searchkey,
            'cronjob' => $domparser->cronjob,
            'email' => $domparser->email,
            'unique' => $domparser->unique,
        ]);
    }
}
