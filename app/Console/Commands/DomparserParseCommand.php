<?php

namespace Laravia\Domparser\App\Console\Commands;

use Cron\CronExpression;
use Illuminate\Console\Command;
use Laravia\Domparser\App\Domparser as AppDomparser;
use Laravia\Domparser\App\Models\Domparser;

class DomparserParseCommand extends Command
{
    public $signature = 'laravia:domparser:parse {--force : force command to run}';
    protected $description = 'laravia domparser parse';

    public function parse()
    {
        foreach (Domparser::all() as $domparser) {

            if ($this->option('force')) {
                $appDomparser = new AppDomparser($domparser->id);
                $appDomparser->run();
            } else {
                $cron = new CronExpression($domparser->cronjob);
                $cron->isDue();
                if ($cron->isDue()) {
                    $appDomparser = new AppDomparser($domparser->id);
                    $appDomparser->run();
                }
            }
        }
    }

    public function handle()
    {
        $this->parse();
        $this->line('parse called successfully');
    }
}
