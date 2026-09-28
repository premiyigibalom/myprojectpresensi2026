<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
// use Illuminate\Foundation\Cloud;
// use PhpParser\Node\Expr\Clone_;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $today = Carbon::today();
        $totalEmployee = User::where('role', 'employee')->count();
        $attendanceToday = Attendance::whereDate('attendance_date', $today);
        $presentToday = $attendanceToday->count();
        $lateToday = (clone $attendanceToday)->where('status', 'late')->count();
        $onTimeToday = (clone $attendanceToday)->where('status', 'on_time')->count();
        $notCheckedIn = $totalEmployee - $presentToday;


        return [
            Stat::make('Total Pegawai', $totalEmployee)
                ->description('Pegawai Terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Hadir Hari Ini', $presentToday)
                ->description("{$onTimeToday} Tepat Waktu, {$lateToday} Terlambat")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Belum Absen', $notCheckedIn)
                ->description('Hari Ini')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),

            // Stat::make('Terlambat', $lateToday)
            //     ->description('Hari Ini')
            //     ->descriptionIcon('heroicon-o-clock')
            //     ->color('warning'),
        ];
    }
}
