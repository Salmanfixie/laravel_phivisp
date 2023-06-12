<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use Harishdurga\LaravelQuiz\Models\Question;
use Harishdurga\LaravelQuiz\Models\Quiz as ModelsQuiz;
use Harishdurga\LaravelQuiz\Models\Topic;

class QuizCreatedChart extends PieChartWidget
{
    protected static ?string $heading = 'Quiz Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [ModelsQuiz::count(), Topic::count(), Question::count()],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => ['Quizzes', 'Topics', 'Questions'],
        ];
    }
}
