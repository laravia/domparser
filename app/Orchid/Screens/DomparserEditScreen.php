<?php

namespace Laravia\Domparser\App\Orchid\Screens;

use Illuminate\Http\Request;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class DomparserEditScreen extends Screen
{
    public $domparser;

    public function query(ModelsDomparser $domparser): array
    {
        return [
            'domparser' => $domparser
        ];
    }

    public function name(): ?string
    {
        return $this->domparser->exists ? 'Edit domparser' : 'Creating a new domparser';
    }

    public function description(): ?string
    {
        return "Domparsers";
    }

    public function commandBar(): array
    {
        return [
            Button::make('Create domparser')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->domparser->exists),

            Button::make('Update')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee($this->domparser->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->domparser->exists),
        ];
    }

    public function layout(): array
    {
        return [
                Layout::rows([
                    Input::make('domparser.url')
                        ->title('Url')
                        ->placeholder('Url')
                        ->required(),
                ]),
                Layout::rows([
                    Input::make('domparser.filter')
                        ->title('Filter')
                        ->placeholder('Filter')
                        ->required(),
                ]),
                Layout::rows([
                    Input::make('domparser.searchkey')
                        ->title('Searchkey')
                        ->placeholder('Searchkey')
                        ->required(),
                ]),
                Layout::rows([
                    Input::make('domparser.cronjob')
                        ->title('Cronjob')
                        ->placeholder('Cronjob Format (* * * * *)')
                        ->required()
                        ->help('<a href="https://crontab.guru/" target="_blank">Cronjob Helper | crontab.guru</a>')
                ]),
                Layout::rows([
                    Input::make('domparser.reset_database_after_seconds')
                        ->title('Reset database after seconds')
                        ->placeholder('Sekunden als Zahl, ohne s hinten dran. Wenn leer, dann wird nicht zurückgesetzt.')
                        ->required()
                        ->help('1 Stunde = 3600, 1 Tag = 86400, 1 Woche = 604800, 1 Monat = 2592000, 3 Monate = 7776000,  1 Jahr = 31536000')
                ]),
                Layout::rows([
                    Input::make('domparser.email')
                        ->title('Email')
                        ->placeholder('Email (if empty the default EMAIL_RECIPIENT_EMAIL will be used))')
                ]),
                Layout::rows([
                    CheckBox::make('domparser.unique')
                        ->title('Unique')
                        ->placeholder('Unique')
                        ->value(true)
                        ->style('margin-bottom:1.25em;')
                        ->help('wenn aktiviert, dann wird für jeden Treffer nur eine Email verschickt. Sonst jedes Mal')
                ]),

        ];
    }

    public function createOrUpdate(Request $request)
    {
        $domparser = $request->get('domparser');
        $domparser['unique'] = isset($domparser['unqiue']);

        $this->domparser->fill($domparser)->save();

        Alert::info('You have successfully created a domparser.');

        return redirect()->route('laravia.domparser.list');
    }

    public function remove()
    {
        $this->domparser->delete();

        Alert::info('You have successfully deleted the domparser.');

        return redirect()->route('laravia.domparser.list');
    }
}
