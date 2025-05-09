<?php
namespace App\Filament\Widgets;

use App\Models\MateriEdukasi;
use App\Models\Supplier;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahMateri   = MateriEdukasi::count();
        $jumlahUser     = User::count();
        $jumlahSupplier = Supplier::count();

        return [
            Stat::make('Jumlah Materi', $jumlahMateri),
            Stat::make('Jumlah Supplier', $jumlahSupplier),
            Stat::make('Jumlah User', $jumlahUser),
        ];

    }
}