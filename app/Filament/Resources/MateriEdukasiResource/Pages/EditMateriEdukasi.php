<?php

namespace App\Filament\Resources\MateriEdukasiResource\Pages;

use App\Filament\Resources\MateriEdukasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMateriEdukasi extends EditRecord
{
    protected static string $resource = MateriEdukasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
