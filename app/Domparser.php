<?php

namespace Laravia\Domparser\App;

use Illuminate\Support\Facades\DB;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Laravia\Heart\App\Laravia;
use Symfony\Component\DomCrawler\Crawler;

class Domparser
{

    public string $content;
    public object $domparser;
    public array $matches;


    public function __construct($id)
    {
        $this->domparser = ModelsDomparser::find($id)->first();
        $this->parse();
    }

    public function parse()
    {

        $html = file_get_contents($this->domparser->url);

        $crawler = new Crawler($html);

        $filter = $crawler->filter($this->domparser->filter)->first();
        $this->content = $filter->text();
    }

    public function find()
    {
        preg_match_all($this->domparser->searchkey, $this->content, $matches);
        $this->matches = $matches;
        return (preg_match($this->domparser->searchkey, $this->content)) ? true : false;
    }

    public function run()
    {
        $state = false;
        if ($this->find()) {
            foreach ($this->matches[0] as $match) {
                $state = $this->runElement($match);
            }
        }
        return $state;
    }

    public function runElement($match)
    {
        $slug = \Str::slug(trim($match));

        $this->resetDomparserLogDatabase();

        if (
            !DB::table('domparserlogs')
                ->where('domparser_id', $this->domparser->id)
                ->where('slug', $slug)
                ->exists()
            ||
            !$this->domparser->unique
        ) {
            DB::table('domparserlogs')->insert([
                'domparser_id' => $this->domparser->id,
                'slug' => $slug,
                'result' => $match,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Laravia::sendEmail(
                "Domparser found",
                "Domparser found {$this->domparser->searchkey} in {$this->domparser->url}",
                $this->domparser->email ?: env('MAIL_DEFAULT_RECIPIENT')
            );

            return true;
        }

        return false;
    }

    public function resetDomparserLogDatabase()
    {
        if ($this->domparser->reset_database_after_seconds) {
            $seconds = $this->domparser->reset_database_after_seconds;
            $date = now()->subSeconds($seconds);
            DB::table('domparserlogs')
                ->where('created_at', '<', $date)
                ->delete();
        }
    }
}
