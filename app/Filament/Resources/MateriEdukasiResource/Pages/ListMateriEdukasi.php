<?php
namespace App\Filament\Resources\MateriEdukasiResource\Pages;

use App\Filament\Resources\MateriEdukasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMateriEdukasi extends ListRecords
{
    protected static string $resource = MateriEdukasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
