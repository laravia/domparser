<?php

namespace Laravia\Domparser\App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravia\Heart\App\Traits\ServiceProviderTrait;

class DomparserServiceProvider extends ServiceProvider
{
    use ServiceProviderTrait;

    protected $name = "domparser";

    public function boot(): void
    {
        $this->defaultBootMethod();
    }
}
