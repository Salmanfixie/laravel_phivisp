<?php

namespace App\Filament\Resources\PhishingSimulationsResource\Widgets;

use App\Models\PhishingSimulations;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class PhishingSimulationsOverview extends BaseWidget
{

    protected function getCards(): array
    {
        $now = Carbon::now();
        $previousMonth = $now->subMonth()->format('F');
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $newSimulationCount = PhishingSimulations::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newInprogresstCount = PhishingSimulations::where('is_sent', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newCompletedCount = PhishingSimulations::where('is_sent', 1)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        return [

            Card::make('Total simulations', PhishingSimulations::count())
                ->description("increase $newSimulationCount from $previousMonth")
                ->chart([0, $newSimulationCount, PhishingSimulations::count()]),

            Card::make('In progress simulations', PhishingSimulations::where('is_sent', 0)->count())
                ->description("increase $newInprogresstCount from $previousMonth")
                ->chart([0, $newInprogresstCount, PhishingSimulations::where('is_sent', 0)->count()]),

            Card::make('Completed simulations', PhishingSimulations::where('is_sent', 1)->count())
                ->description("increase $newCompletedCount from $previousMonth")
                ->chart([0, $newCompletedCount, PhishingSimulations::where('is_sent', 1)->count()]),

        ];
    }
}
