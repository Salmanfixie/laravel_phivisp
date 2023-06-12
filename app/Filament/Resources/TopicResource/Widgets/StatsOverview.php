<?php

namespace App\Filament\Resources\TopicResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Harishdurga\LaravelQuiz\Models\Topic as ModelsTopic;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total topics', ModelsTopic::all()->count()),
            Card::make('Active topics', ModelsTopic::where('is_active', 1)->count()),
            Card::make('Last created on', ModelsTopic::pluck('created_at')->last()),
        ];
    }
}
