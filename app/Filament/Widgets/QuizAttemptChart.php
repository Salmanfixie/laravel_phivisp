<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Harishdurga\LaravelQuiz\Models\QuizAttemptAnswer;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;

class QuizAttemptChart extends BarChartWidget
{
    protected static ?string $heading = 'Quiz Attempt Chart';

    protected function getData(): array
    {
        $QuizAttemptAnswer = Trend::model(QuizAttemptAnswer::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $QuizAttempt = Trend::model(QuizAttempt::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => ' Quiz Attempts',
                    'data' => $QuizAttempt->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(54, 162, 235)',
                    ],
                ],
                [
                    'label' => 'Question Answers',
                    'data' => $QuizAttemptAnswer->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(54, 162, 235)',
                    ],
                ],
            ],
            'labels' => $QuizAttempt->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public static function canView(): bool
    {
        return !auth()->user()->hasRole('super_admin');
    }
}
