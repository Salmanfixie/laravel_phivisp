<?php

namespace App\Filament\Resources\QuizResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Harishdurga\LaravelQuiz\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Illuminate\Support\Carbon;

class QuizOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = $now->endOfMonth()->format('Y-m-d H:i:s');

        $newQuizCount = Quiz::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newPublishCount = Quiz::where('is_published', 1)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $newAttemptCount = QuizAttempt::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        return [
            Card::make('Total quizzes', Quiz::count())
                ->description("increase $newQuizCount from last month")
                ->chart([0, $newQuizCount, Quiz::count()]),

            Card::make('Published quizzes', Quiz::where('is_published', 1)->count())
                ->description("increase $newPublishCount from last month")
                ->chart([0, $newPublishCount, Quiz::count()]),

            Card::make('Quiz Attempts', QuizAttempt::count())
                ->description("increase $newAttemptCount from last month")
                ->chart([0, $newAttemptCount, QuizAttempt::count()]),
        ];
    }
}
