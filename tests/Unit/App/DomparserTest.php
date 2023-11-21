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



    public function testDatabaseResetAfterSecondsSuccessful()
    {
        $this->domparserlogData(2);
        $this->assertEquals(
            0,
            \DB::table('domparserlogs')
                ->where('domparser_id', $this->testData->id)
                ->count()
        );
        $this->testData->delete();
    }

    public function testDatabaseResetAfterSecondsFailed()
    {
        $this->domparserlogData(1);
        $this->assertEquals(
            1,
            \DB::table('domparserlogs')
                ->where('domparser_id', $this->testData->id)
                ->count()
        );
        $this->testData->delete();
    }

    protected function createTestData($searchkey, $reset_database_after_seconds = 100)
    {
        $url = Laravia::path()->get('domparser') . "/tests/documents/test.html";
        $filter = 'div#testdiv';

        $this->testData =  ModelsDomparser::factory([
            'url' => $url,
            'filter' => $filter,
            'searchkey' => $searchkey,
            'reset_database_after_seconds' => $reset_database_after_seconds,
        ])->create();
    }

    protected function domparserlogData($resetDatabaseAfterSeconds = 2)
    {
        $this->createTestData('/site for testing/i', 1);
        $domparser = new Domparser($this->testData->id);
        \DB::table('domparserlogs')->insert(
            [
                'domparser_id' => $this->testData->id,
                'slug' => 'test',
                'result' => 'test',
                'created_at' => now()->subSeconds($resetDatabaseAfterSeconds),
                'updated_at' => now(),
            ]
        );
        $domparser->resetDomparserLogDatabase();
    }
}
