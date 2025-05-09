<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MateriEdukasiResource\Pages;
use App\Models\MateriEdukasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MateriEdukasiResource extends Resource
{
    protected static ?string $model = MateriEdukasi::class;

    protected static ?string $navigationLabel = 'Kelola Materi Edukasi'; // Ubah nama di sidebar
    protected static ?string $navigationIcon  = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Materi'),

                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->label('Deskripsi Materi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Buat')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMateriEdukasi::route('/'),
            'create' => Pages\CreateMateriEdukasi::route('/create'),
            'edit'   => Pages\EditMateriEdukasi::route('/{record}/edit'),
        ];
    }
}