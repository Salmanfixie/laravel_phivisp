<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Harishdurga\LaravelQuiz\Models\Question;
use Harishdurga\LaravelQuiz\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Harishdurga\LaravelQuiz\Models\Topicable;
use Illuminate\Database\Eloquent\Model;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;

    protected function handleRecordCreation(array $data): Quiz
    {
        $quiz = Quiz::create($data);

        // save all the general questions that does not belong to any topics into QuizQuestion

        // 1. get all questions from Topicable
        $questionsWithTopic = Topicable::where(
            'topicable_type',
            'Harishdurga\LaravelQuiz\Models\Question',
        )->pluck('topicable_id');

        // 2. get all questions
        $allQuestions = Question::get();

        // 3. get all questions that does not have topic
        $generalQuestions = $allQuestions->whereNotIn('id', $questionsWithTopic);

        // 4. save $generalQuestions into QuizQuestion
        foreach ($generalQuestions as $generalQuestion) {

            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question_id' => ($generalQuestion->id),
            ]);
        }

        return $quiz;
    }
}
