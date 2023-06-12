<?php

namespace App\Filament\Resources\QuestionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Harishdurga\LaravelQuiz\Models\Question as ModelsQuestion;

class QuestionOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total questions', ModelsQuestion::all()->count()),

            Card::make('Active questions', ModelsQuestion::where('is_active', 1)->count()),
            
            Card::make('Last created on', ModelsQuestion::pluck('created_at')->last()),
        ];
    }
}
