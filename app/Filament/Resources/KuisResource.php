<?php
namespace App\Filament\Resources;

use App\Filament\Resources\KuisResource\Pages;
use App\Models\Kuis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KuisResource extends Resource
{
    protected static ?string $model = Kuis::class;

    protected static ?string $navigationGroup = 'Kelola Materi 📚';
    protected static ?int $navigationSort     = 3; // di BabMateriResource

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('materi_id')
                ->label('Materi')
                ->relationship('materi', 'judul') // sesuaikan dengan nama relasi di model Kuis
                ->required(),

            Forms\Components\Textarea::make('pertanyaan')
                ->label('Pertanyaan')
                ->required(),

            Forms\Components\TextInput::make('opsi_a')->label('Opsi A')->required(),
            Forms\Components\TextInput::make('opsi_b')->label('Opsi B')->required(),
            Forms\Components\TextInput::make('opsi_c')->label('Opsi C')->required(),
            Forms\Components\TextInput::make('opsi_d')->label('Opsi D')->required(),

            Forms\Components\Select::make('jawaban_benar')
                ->label('Kuis')
                ->options([
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                    'd' => 'D',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('materi.judul')
                    ->label('Materi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('opsi_a')->label('Opsi A'),
                TextColumn::make('opsi_b')->label('Opsi B'),
                TextColumn::make('opsi_c')->label('Opsi C'),
                TextColumn::make('opsi_d')->label('Opsi D'),

                TextColumn::make('jawaban_benar')
                    ->label('Jawaban Benar')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
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
            'index'  => Pages\ListKuis::route('/'),
            'create' => Pages\CreateKuis::route('/create'),
            'edit'   => Pages\EditKuis::route('/{record}/edit'),
        ];
    }
}