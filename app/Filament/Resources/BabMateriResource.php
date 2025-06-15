<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BabMateriResource\Pages;
use App\Filament\Resources\BabMateriResource\RelationManagers\SubmaterisRelationManager;
use App\Models\BabMateri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BabMateriResource extends Resource
{
    protected static ?string $model = BabMateri::class;

    protected static ?string $navigationGroup = 'Kelola Materi 📚';

    protected static ?int $navigationSort = 1; // di BabMateriResource

    protected static ?string $navigationLabel = ' Bab Materi Edukasi';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_bab')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Bab'),

                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->label('Deskripsi Bab'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul_bab')
                    ->label('Judul Bab')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Bisa ditambahkan filter jika perlu
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
            SubmaterisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBabMateris::route('/'),
            'create' => Pages\CreateBabMateri::route('/create'),
            'edit'   => Pages\EditBabMateri::route('/{record}/edit'),
        ];
    }
}