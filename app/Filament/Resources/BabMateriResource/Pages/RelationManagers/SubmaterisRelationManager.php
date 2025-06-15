<?php
namespace App\Filament\Resources\BabMateriResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
namespace App\Filament\Resources\BabMateriResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class SubmaterisRelationManager extends RelationManager
{
    protected static string $relationship = 'subMateri'; // Sesuai relasi di model BabMateri

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->label('Judul Sub Materi'),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi Sub Materi'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->label('Judul'),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Sub Materi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Hapus Banyak'),
            ]);
    }
}