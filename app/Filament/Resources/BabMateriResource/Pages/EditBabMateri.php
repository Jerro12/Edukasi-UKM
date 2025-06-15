<?php

namespace App\Filament\Resources\BabMateriResource\Pages;

use App\Filament\Resources\BabMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBabMateri extends EditRecord
{
    protected static string $resource = BabMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
