<?php

namespace Laravia\Domparser\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laravia\Domparser\App\Models\Domparser;

class DomparserFactory extends Factory
{
    protected $model = Domparser::class;

    public function definition()
    {
        return [
            'url' => $this->faker->url,
            'filter' => $this->faker->word,
            'searchkey' => 'test',
            'cronjob' => "* * * * *",
            'email' => $this->faker->email,
            'unique' => true,
            'reset_database_after_seconds' => 600,
        ];
    }
}
