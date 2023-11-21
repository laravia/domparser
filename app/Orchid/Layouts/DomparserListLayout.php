<?php

namespace Laravia\Domparser\App\Orchid\Layouts;

use Laravia\Domparser\App\Models\Domparser;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class DomparserListLayout extends Table
{
    public $target = 'domparsers';

    public function columns(): array
    {
        return [

            TD::make('url', 'Url')->sort(),

            TD::make('filter', 'Filter')->sort(),

            TD::make('searchkey', 'Searchkey')->sort(),

            TD::make('cronjob', 'Cronjob')->sort(),

            TD::make('email', 'Email')->sort(),

            TD::make('reset_database_after_seconds', 'Reset Database (seconds)')->sort(),

            TD::make('unique', 'Unique')->sort()->render(function (Domparser $domparser) {
                return $domparser->unique ? __('laravia.heart::common.yes') : __('laravia.heart::common.no');
            }),


            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Domparser $domparser) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('laravia.domparser.edit', $domparser->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the domparser entry is deleted, all of its resources and data will be permanently deleted.'))
                            ->method('remove', [
                                'id' => $domparser->id,
                            ]),
                    ]))
        ];
    }
}
