<?php
namespace Laravia\Domparser\Tests\Unit\App\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Laravia\Domparser\App\Console\Commands\DomparserParseCommand;
use Laravia\Heart\App\Classes\TestCase;

class DomparserParseCommandTest extends TestCase
{
    public function testInitClass()
    {
        $this->assertClassExist(DomparserParseCommand::class);
    }

    public function testHandle()
    {
        $this->assertMethodInClassExists('handle', DomparserParseCommand::class);
    }

    public function testInstallMethodExists()
    {
        $this->assertMethodInClassExists('parse', DomparserParseCommand::class);
    }

    public function testDomparserParseCommand()
    {
        Artisan::shouldReceive('call')
            ->once()
            ->with('laravia:domparser:parse')
            ->andReturn('parse called successfully');

        Artisan::call('laravia:domparser:parse');
    }
}
