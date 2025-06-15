<?php

namespace App\Filament\Resources\BabMateriResource\Pages;

use App\Filament\Resources\BabMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBabMateris extends ListRecords
{
    protected static string $resource = BabMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
