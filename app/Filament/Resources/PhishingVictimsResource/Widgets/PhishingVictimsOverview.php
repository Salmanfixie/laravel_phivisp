<?php

namespace App\Filament\Resources\PhishingVictimsResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\PhishingVictims;
use Illuminate\Support\Carbon;

class PhishingVictimsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $now = Carbon::now();
        $currentMonth = $now->format('F');
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $newDataCount = PhishingVictims::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        return [
            Card::make('Total victims', PhishingVictims::all()->count()),
            Card::make("Total victims in $currentMonth", $newDataCount),
            Card::make('Last created on', PhishingVictims::pluck('created_at')->last()),
        ];
    }
}
