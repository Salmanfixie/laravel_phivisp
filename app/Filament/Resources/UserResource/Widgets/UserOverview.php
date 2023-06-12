<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class UserOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $now = Carbon::now();
        $currentMonth = $now->format('F');
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $newDataCount = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        return [
            Card::make('Total users', User::all()->count()),
            Card::make('Active users', User::all()->count()),
            Card::make("Total users in $currentMonth", $newDataCount),
        ];
    }
}
