<?php

namespace App\Filament\Widgets;


use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestAttendanceWidget extends TableWidget
{
    protected static ?string $heading = 'Kehadiran Hari Ini';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn(): Builder => Attendance::query()
                    ->with('user')
                    ->whereDate('attendance_date', Carbon::today())
                    ->latest('check_in_time')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.employee_id')
                    ->label('ID Pegawai')
                    ->searchable(),
                TextColumn::make('check_in_time')
                    ->label('Check-In')
                    ->searchable(),
                TextColumn::make('check_out_time')
                    ->label('Check-Out')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'on_time',
                        'warning' => 'late',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'on_time' => 'Tepat Waktu',
                        'late' => 'Terlambat',
                        default => $state,
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
