<?php

namespace Laravia\Domparser\App\Orchid\Screens;

use Illuminate\Http\Request;
use Laravia\Domparser\App\Models\Domparser as ModelsDomparser;
use Laravia\Domparser\App\Orchid\Layouts\DomparserListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class DomparserScreen extends Screen
{

    public function query(): iterable
    {
        return [
            'domparsers' => ModelsDomparser::orderByDesc('id')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Domparser Screen';
    }

    public function description(): ?string
    {
        return 'Domparsers of Laravia';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Create new domparser')
                ->icon('pencil')
                ->route('laravia.domparser.edit')
        ];
    }

    public function layout(): iterable
    {
        return [
            DomparserListLayout::class
        ];
    }

    public function remove(Request $request): void
    {
        ModelsDomparser::findOrFail($request->get('id'))->delete();

        Alert::info('You have successfully deleted the domparser.');
    }
}
