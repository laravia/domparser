<?php

namespace Laravia\Domparser\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravia\Domparser\Database\Factories\DomparserFactory;
use Laravia\Heart\App\Models\Model;
use Orchid\Screen\AsSource;

class Domparser extends Model
{
    use AsSource, HasFactory;
    protected $fillable = [
        'url',
        'filter',
        'searchkey',
        'cronjob',
        'email',
        'unique',
        'reset_database_after_seconds'
    ];

    protected static function newFactory()
    {
        return DomparserFactory::new();
    }

}
