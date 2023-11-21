<?php

namespace Laravia\Domparser\Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Laravia\Heart\App\Classes\TestCase;
use Laravia\Domparser\App\Domparser;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Laravia\Heart\App\Laravia;

class DomparserTest extends TestCase
{
    protected object $testData;

    public function testInitClass()
    {
        $this->assertClassExist(Domparser::class);
    }

    public function testParseExists()
    {
        $this->assertMethodInClassExists('parse', Domparser::class);
    }

    protected function createTestData($searchkey)
    {
        $url = Laravia::path()->get('domparser') . "/tests/documents/test.html";
        $filter = 'div#testdiv';

        $this->testData =  ModelsDomparser::factory([
            'url' => $url,
            'filter' => $filter,
            'searchkey' => $searchkey,
        ])->create();
    }

    public function testFindSucceed()
    {
        $this->createTestData('/site for testing/i');
        $domparser = new Domparser($this->testData->id);
        $this->assertTrue($domparser->find());

        $this->testData->delete();
    }

    public function testFindFailed()
    {
        $this->createTestData('/singing a song/i');
        $domparser = new Domparser($this->testData->id);
        $this->assertFalse($domparser->find());

        $this->testData->delete();
    }

    public function testRunSucceed()
    {
        Mail::fake();

        $this->createTestData('/site for testing/i');
        $domparser = new Domparser($this->testData->id);

        $this->assertTrue($domparser->run());

        $this->testData->delete();
        \DB::table('domparserlogs')->truncate();
    }

    public function testRunSucceedButDoubleResultAndStateFalseReturned()
    {
        Mail::fake();

        $this->createTestData('/site for testing/i');
        $domparser = new Domparser($this->testData->id);
        $domparser->run();

        //run second time for testing with empty result
        $domparser = new Domparser($this->testData->id);
        $this->assertFalse($domparser->run());

        $this->testData->delete();
        \DB::table('domparserlogs')->truncate();
    }
}
