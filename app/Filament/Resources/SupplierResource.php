<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationLabel = 'Kelola Supplier';
    protected static ?string $navigationIcon  = 'heroicon-o-briefcase';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Supplier')
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat Supplier')
                    ->required(),

                Textarea::make('email')
                    ->label('Email Supplier')
                    ->required(),
                Textarea::make('layanan')
                    ->label('Layanan')
                    ->required(),
                Textarea::make('kontak')
                    ->label('Kontak')
                    ->required(),

                // Tambahkan kolom lain sesuai kebutuhan
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable(),
                Tables\Columns\TextColumn::make('alamat')->sortable(),
                Tables\Columns\TextColumn::make('email')->sortable(),
                Tables\Columns\TextColumn::make('layanan')->sortable(),
                Tables\Columns\TextColumn::make('kontak')->sortable(),
                // Kolom lainnya sesuai kebutuhan
            ])
            ->filters([
                // Filters jika diperlukan
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit'   => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}