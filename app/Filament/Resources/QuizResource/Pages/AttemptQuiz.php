<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use Exception;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Harishdurga\LaravelQuiz\Models\Question;
use Harishdurga\LaravelQuiz\Models\QuestionOption;
use Harishdurga\LaravelQuiz\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Harishdurga\LaravelQuiz\Models\QuizAttemptAnswer;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class AttemptQuiz extends Page
{
    protected static string $resource = QuizResource::class;

    protected static string $view = 'filament.resources.quiz-resource.pages.attempt-quiz';

    public $answered;
    public $question;
    public $question_option_id;
    public $optionIsCorrect;
    public $optionExplanation;
    public $quizQuestions;
    public $questionId;
    public $quizQuestion;
    public $quizAttemptId;
    public $quizId;
    public $buttonDisabled = false;
    public $questionImage;

    public function mount($record, $quizQuestion)
    {
        $this->answered();

        // get id from QuizAttempt
        $quizAttemptId = QuizAttempt::where([
            'quiz_id' => $record,
            'participant_id' => Auth::id(),
        ])->value('id');

        // check if question already answered
        $option = QuizAttemptAnswer::where([
            'quiz_question_id' => $quizQuestion,
            'quiz_attempt_id' => $quizAttemptId,
        ])->value('question_option_id');

        $questionId = QuizQuestion::where('id', $quizQuestion)->value('question_id');
        $this->questionId = $questionId;

        $question = Question::where('id', $questionId)->value('name');
        $questionImage = Question::where('id', $questionId)->value('image_path');

        $quizId = Route::current()->parameter('record');

        $this->question = $question;
        $this->questionImage = $questionImage;
        $this->quizQuestion = $quizQuestion;
        $this->quizAttemptId = $quizAttemptId;
        $this->quizId = $quizId;

        if (is_null($option)) {
            // column is empty
            $question = Question::where('id', $questionId)->value('name');

            $this->question = $question;
        } else {
            // column is not empty/ already has answer

            // retrieve option from $this->form
            $this->form->fill([
                'question_option_id' => $option,
            ]);

            $this->explanation();
        }
    }

    public function submitAnswer()
    {
        if ($this->form->getState()['question_option_id'] == null) {
            Notification::make()
                ->title(__('There are no answer selected'))
                ->danger()
                ->body(__('Please select one option for the question'))
                ->send();
        }

        // disable the form
        $this->form->disabled();

        // save answer in QuizAttemptAnswer
        QuizAttemptAnswer::where([
            // check quiz_attempt_id as well
            'quiz_attempt_id' => $this->quizAttemptId,
            'quiz_question_id' => $this->quizQuestion,
        ])->update(['question_option_id' => $this->form->getState()['question_option_id']]);

        $nextQuestionId = $this->quizQuestion + 1;

        $questionExists = QuizQuestion::where('id', $nextQuestionId)
            ->where('quiz_id', $this->quizId)
            ->exists();

        if (!$questionExists) {
            Notification::make()
                ->title('There are no more questions left')
                ->warning()
                ->body('Navigate to your answered questions to revise')
                ->send();
        } else {
            // create new attempt for next question
            $newAttempt = QuizAttemptAnswer::create([
                'quiz_attempt_id' => $this->quizAttemptId,
                'quiz_question_id' => $this->quizQuestion + 1,
                'question_option_id' => null,
            ]);
        }

        // show the explanation
        $this->explanation();
    }

    public function explanation()
    {
        $this->form->disabled();
        // show result and explanation
        $optionDetails = QuestionOption::where('id', $this->form->getState())->pluck('explanation', 'is_correct');

        $optionIsCorrect = $optionDetails->keys()->first();
        $optionExplanation = $optionDetails->first();

        $this->optionIsCorrect = $optionIsCorrect;
        $this->optionExplanation = $optionExplanation;
    }

    // navigate to the prev question
    public function previous()
    {
        // current quizAttemptAnswer
        $currentAttemptAnswer = QuizAttemptAnswer::where([
            'quiz_question_id' => $this->quizQuestion,
            'quiz_attempt_id' => $this->quizAttemptId,
        ])->value('created_at');

        // previous quizAttemptAnswer
        $prevAttemptAnswer = QuizAttemptAnswer::where([
            'quiz_attempt_id' => $this->quizAttemptId,
        ])->where('created_at', '<', $currentAttemptAnswer)->first(); // if there are multiple questions answered before, first() will which one?

        if (!$prevAttemptAnswer) {
            $this->buttonDisabled = true;

            // send warning notification
            Notification::make()
                ->title(__('There are no questions before'))
                ->warning()
                ->body(__('Navigate to your answered questions to revise'))
                ->send();

            // disable form
            $hasAnswer = QuizAttemptAnswer::where([
                'quiz_question_id' => $this->quizQuestion,
                'quiz_attempt_id' => $this->quizAttemptId,
            ])->value('question_option_id');

            if ($hasAnswer) {
                $this->form->disabled();
            }
        } else {
            $prevQuizQuestion = $prevAttemptAnswer->quiz_question_id;

            return redirect(QuizResource::getURL('attempt', [$this->quizId, $prevQuizQuestion]));
        }
    }

    // continue to the next question
    public function continue()
    {
        // check form first
        if ($this->form->getState()['question_option_id'] == null) {
            Notification::make()
                ->title(__('There are no answer selected'))
                ->danger()
                ->body(__('Please select one option for the question'))
                ->send();
        }

        // current quizAttemptAnswer
        $currentAttemptAnswer = QuizAttemptAnswer::where([
            'quiz_question_id' => $this->quizQuestion,
            'quiz_attempt_id' => $this->quizAttemptId,
        ])->value('created_at');

        // next quizAttemptAnswer
        $nextAttemptAnswer = QuizAttemptAnswer::where([
            'quiz_attempt_id' => $this->quizAttemptId,
        ])->where('created_at', '>', $currentAttemptAnswer)->first();

        if (!$nextAttemptAnswer) {
            $this->buttonDisabled = true;

            Notification::make()
                ->title('There are no more questions left')
                ->warning()
                ->body('Navigate to your answered questions to revise')
                ->send();

            // disable form
            $hasAnswer = QuizAttemptAnswer::where([
                'quiz_question_id' => $this->quizQuestion,
                'quiz_attempt_id' => $this->quizAttemptId,
            ])->value('question_option_id');

            if ($hasAnswer) {
                $this->form->disabled();
            }
        } else {
            $nextQuizQuestion = $nextAttemptAnswer->quiz_question_id;

            return redirect(QuizResource::getURL('attempt', [$this->quizId, $nextQuizQuestion]));
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Radio::make('question_option_id')
                ->label('')
                ->required()
                ->options(
                    QuestionOption::where('question_id', $this->questionId)
                        ->pluck('name', 'id')
                ),
        ];
    }

    public function answered()
    {
        // count total answered questions for the system
        $answered = QuizAttemptAnswer::all()->count();

        $this->answered = $answered;
    }
}
