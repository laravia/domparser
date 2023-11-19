<?php

namespace Laravia\Domparser\App\Orchid\Screens;

use Illuminate\Http\Request;
use Laravia\Heart\App\Laravia;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
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
            Layout::columns([
                Layout::rows([
                    Input::make('domparser.url')
                        ->title('Url')
                        ->placeholder('Url')
                        ->required(),
                ]),
                Layout::rows([
                    Input::make('domparser.element')
                        ->title('Element')
                        ->placeholder('Element')
                        ->required(),
                ]),
                Layout::rows([
                    Select::make('domparser.cronjob')
                        ->title('Cronjob')
                        ->placeholder('Cronjob Format (* * * * *)')
                        ->required()
                ]),
                Layout::rows([
                    Select::make('domparser.email')
                        ->title('Email')
                        ->placeholder('Email (if empty the default EMAIL_RECIPIENT_EMAIL will be used))')
                        ->required()
                ]),
                CheckBox::make('domparser.unique')
                ->title('Unique')
                ->placeholder('Unique')
                ->value(true)
                ->style('margin-bottom:1.25em;'),
                ]),


        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->domparser->fill($request->get('domparser'))->save();

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
