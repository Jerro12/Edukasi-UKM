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

    protected static ?string $navigationGroup = 'Kelola Materi 📚';
    protected static ?int $navigationSort     = 2; // di BabMateriResource

    protected static ?string $navigationLabel = 'Sub Materi Edukasi';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bab_materi_id')
                    ->label('Bab Materi')
                    ->relationship('babMateri', 'judul_bab') // relasi model
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Materi'),

                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->label('Deskripsi Materi'),
                 // ⬇⬇ Tambahan Upload Gambar di sini
            Forms\Components\FileUpload::make('gambar')
            ->label('Gambar Materi')
            ->directory('gambar-materi') // simpan di storage/app/public/gambar-materi
            ->image()
            ->imagePreviewHeight('150')
            ->downloadable()
            ->openable()
            ->required(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('babMateri.judul_bab')
                    ->label('Bab Materi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50),
                
                    Tables\Columns\ImageColumn::make('gambar')
    ->label('Gambar')
    ->disk('public') // ⬅️ ini penting, sesuaikan dengan disk kamu
    ->circular()
    ->height(60),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Buat')
                    ->dateTime('d M Y'),
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
        return [];
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