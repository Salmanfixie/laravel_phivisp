<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Harishdurga\LaravelQuiz\Models\Question;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Harishdurga\LaravelQuiz\Models\Topicable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopicsRelationManager extends RelationManager
{
    protected static string $relationship = 'topics';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('question_count')
                    ->label('No. of Questions')
                    ->getStateUsing(function ($record) {
                        // count number of questions belongs to the topic
                        $questions = Topicable::where([
                            ['topic_id', $record->id],
                            ['topicable_type', 'Harishdurga\LaravelQuiz\Models\Question'],
                        ])->count();

                        return $questions;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Attach topic')
                    ->after(
                        function (RelationManager $livewire, $data) {
                            // save all the questions of the attached topic into QuizQuestion

                            // 1. get all the questions of the topic, from Topicable
                            $questionIds = Topicable::where([
                                ['topic_id', $data],
                                ['topicable_type', 'Harishdurga\LaravelQuiz\Models\Question'],
                            ])->pluck('topicable_id');

                            // 2. insert quizId and questionId into QuizQuestion
                            foreach ($questionIds as $questionId) {
                                QuizQuestion::create([
                                    'quiz_id' => $livewire->ownerRecord->id,
                                    'question_id' => $questionId,
                                ]);
                            }
                        }
                    )
            ])
            ->actions([
                // make sure to remove the questions of a topic from QuizQuestion after detaching the topic
                Tables\Actions\DetachAction::make()
                    ->before(
                        function (RelationManager $livewire, $record) {

                            $questionIds = Topicable::where([
                                ['topic_id', $record->id],
                                ['topicable_type', 'Harishdurga\LaravelQuiz\Models\Question'],
                            ])->pluck('topicable_id');

                            foreach ($questionIds as $questionId) {
                                QuizQuestion::where([
                                    'quiz_id' => $livewire->ownerRecord->id,
                                    'question_id' => $questionId,
                                ])->update([
                                    'deleted_at' => now()
                                ]);
                            }
                        }
                    ),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
