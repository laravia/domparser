<?php

use Illuminate\Support\Facades\Route;
use Laravia\Domparser\App\Orchid\Screens\DomparserEditScreen;
use Laravia\Domparser\App\Orchid\Screens\DomparserScreen;
use Tabuna\Breadcrumbs\Trail;

$prefix = config('platform.prefix');

Route::middleware(['web', 'auth', 'platform'])->group(function () use ($prefix) {

    Route::screen($prefix . '/domparsers', DomparserScreen::class)
        ->name('laravia.domparser.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Domparser');
        });

    Route::screen($prefix . '/domparser/{domparser?}', DomparserEditScreen::class)
        ->name('laravia.domparser.edit')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('laravia.domparser.list')
            ->push(__('Domparser edit or create'), route('laravia.domparser.list')));

});
