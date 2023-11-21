<?php

namespace Laravia\Domparser\App\Console\Commands;

use Illuminate\Console\Command;
use Laravia\Domparser\App\Domparser as AppDomparser;
use Laravia\Domparser\App\Models\Domparser;

class DomparserParseCommand extends Command
{
    public $signature = 'laravia:domparser:parse {--force : force command to run}';
    protected $description = 'laravia domparser parse';

    public function parse()
    {
        foreach(Domparser::all() as $domparser) {

            $appDomparser = new AppDomparser($domparser->id);
            if($this->option('force')){
                $appDomparser->run();
            }
        }
    }

    public function handle()
    {
        $this->parse();
        $this->line('parse called successfully');
    }
}
