<?php

namespace App\Filament\Widgets;

use App\Models\PhishingData;
use App\Models\User;
use App\Models\PhishingSimulations;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Tables\UserTable;
use Illuminate\Support\Carbon;

class DashboardOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $newUserCount = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newPhishingCount = PhishingData::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newSimulationCount = PhishingSimulations::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        return [
            Card::make('Total Users', User::count())
                ->description("increase $newUserCount from last month")
                ->chart([0, $newUserCount, User::count()]),

            Card::make('Phishing Data', PhishingData::count())
                ->description("increase $newPhishingCount from last month")
                ->chart([0, $newPhishingCount, PhishingData::count()]),

            Card::make('Phishing Simulations', PhishingSimulations::count())
                ->description("increase $newSimulationCount from last month")
                ->chart([0, $newSimulationCount, PhishingSimulations::count()]),
        ];
    }
}
