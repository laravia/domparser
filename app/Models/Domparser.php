<?php

namespace Laravia\Domparser\App\Models;

use Laravia\Heart\App\Models\Model;
use Orchid\Screen\AsSource;

class Domparser extends Model
{
    use AsSource;
    protected $fillable = [
        'url',
        'element',
        'cronjob',
        'email',
        'unique',
    ];

}
