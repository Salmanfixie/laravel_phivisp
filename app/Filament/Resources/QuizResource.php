<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\Pages\CreateQuiz;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Filament\Resources\QuizResource\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\QuizResource\RelationManagers\TopicsRelationManager;
use App\Filament\Resources\QuizResource\Widgets\QuizOverview;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Http\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Harishdurga\LaravelQuiz\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Harishdurga\LaravelQuiz\Models\QuizAttemptAnswer;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Harishdurga\LaravelQuiz\Models\Topicable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Icetalker\FilamentStepper\Forms\Components\Stepper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RalphJSmit\Filament\Components\Forms\Timestamps;
use RalphJSmit\Filament\Components\Forms\Sidebar;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Quiz';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('General'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('name'))
                            ->required(),

                        TextInput::make('slug')
                            ->required(),

                        Textarea::make('description')
                            ->label(__('description'))
                            ->required(),

                        Toggle::make('is_published')
                            ->label(__('Published'))
                            ->onIcon('heroicon-s-lightning-bolt')
                            ->offIcon('heroicon-s-lightning-bolt')
                            ->default(true)
                            ->inline(false),

                        FileUpload::make('media_url')
                            ->disk('quiz')
                            ->image()
                            // 12 mb
                            ->maxSize(12000)
                            ->required()
                            ->label(__('Image'))
                            ->placeholder(__('Upload Quiz Image Here'))
                            ->imageCropAspectRatio('18:9')
                            ->imageResizeTargetWidth('720')
                            ->imageResizeTargetHeight('350'),

                    ])->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('media_url')
                    ->width(330)
                    ->height(100)
                    ->square()
                    ->disk('quiz')
                    ->extraImgAttributes([
                        'title' => 'Quiz Image',
                    ]),

                TextColumn::make('name')
                    ->label(__('name'))
                    ->sortable()
                    ->searchable()
                    ->weight('medium')
                    ->limit(50),

                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->limit(50)
                    ->label('Slug')
                    ->hidden(
                        function (?Model $record) {
                            if (auth()->user()->hasRole('filament_user')) {
                                // if filament_user, hide column
                                return true;
                            }
                            // show column if not filament_user
                            return false;
                        }
                    ),

                // show how many topics of a quiz
                TextColumn::make('topic_count')
                    ->getStateUsing(function ($record) {
                        $topics = Topicable::where([
                            'topicable_id' => $record->id,
                            'topicable_type' => 'Harishdurga\LaravelQuiz\Models\Quiz',
                        ])->count();

                        return $topics . ' topics';
                    })
                    ->icon('heroicon-o-academic-cap'),

                // show how many questions of a quiz
                TextColumn::make('question_count')
                    ->getStateUsing(function ($record) {
                        $questions = QuizQuestion::where('quiz_id', $record->id)->count();

                        return $questions . ' questions';
                    })
                    ->icon('heroicon-o-collection'),

                // nanti buat only show published
                BooleanColumn::make('is_published')
                    ->label('Published')
                    ->hidden(
                        function (?Model $record) {
                            if (auth()->user()->hasRole('filament_user')) {
                                // if filament_user, hide column
                                return true;
                            }
                            // show column if not filament_user
                            return false;
                        }
                    ),

                Panel::make([
                    TextColumn::make('description')
                        ->size('sm'),
                ])->collapsible(),
            ])
            ->filters([
                Filter::make('Published')
                    ->default(true)
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // for first time attempting the quiz
                Action::make('attemptQuiz')
                    ->label(__('Start'))
                    ->action(function ($livewire, Quiz $record, array $data): void {
                        $quizAttempt = $record->attempts()->create([
                            'quiz_id' => $record->id,
                            'participant_id' => Auth::id(),
                            'participant_type' => 'filament_user',
                        ]);

                        $quizQuestions = QuizQuestion::where('quiz_id', $record->id)->pluck('question_id', 'id');
                        $quizQuestionId = $quizQuestions->keys()->first();

                        // create QuizAttemptAnswer later
                        QuizAttemptAnswer::create([
                            'quiz_attempt_id' => $quizAttempt->id,
                            'quiz_question_id' => $quizQuestionId,
                            'question_option_id' => null,
                        ]);

                        $livewire->redirect(QuizResource::getURL('attempt', [$record->id, $quizQuestionId]));
                    })
                    ->requiresConfirmation()
                    ->modalHeading(__('Start Quiz'))
                    ->modalSubheading('Are you sure you\'d like to attempt the quiz?')
                    ->modalButton('Yes')
                    ->icon('heroicon-s-book-open')
                    ->hidden(
                        function (Quiz $record) {
                            if (auth()->user()->hasRole('super_admin')) {
                                // if super_admin, hide action
                                return true;
                            } else {
                                // if filament_user, show action
                                // handle if user is currently already attempting the quiz

                                $existingAttempt = QuizAttempt::where([
                                    'quiz_id' => $record->id,
                                    'participant_id' => Auth::id(),
                                ])->first();

                                if ($existingAttempt == null) {
                                    return false;
                                } else {
                                    // hide 
                                    return true;
                                }
                            }
                        }
                    ),

                // action for continuing existing quiz attempt
                Action::make('continueQuiz')
                    ->label(__('Continue'))
                    ->action(function ($livewire, Quiz $record): void {
                        // get existing quiz attempt`
                        $quizAttemptId = QuizAttempt::where('quiz_id', $record->id)->pluck('id')->first();

                        $quizQuestionId = QuizAttemptAnswer::where([
                            'quiz_attempt_id' => $quizAttemptId,
                            'question_option_id' => null
                        ])->value('quiz_question_id');

                        if (!$quizQuestionId) {

                            $quizQuestionId = QuizAttemptAnswer::where([
                                'quiz_attempt_id' => $quizAttemptId,
                            ])->first()->value('quiz_question_id');

                            $livewire->redirect(QuizResource::getURL('attempt', [$record->id, $quizQuestionId]));
                        }

                        $livewire->redirect(QuizResource::getURL('attempt', [$record->id, $quizQuestionId]));
                    })
                    ->requiresConfirmation()
                    ->modalHeading(__('Continue Quiz'))
                    ->modalSubheading('Are you sure you\'d like to continue the quiz?')
                    ->modalButton('Yes')
                    ->icon('heroicon-s-arrow-right')
                    ->hidden(
                        function (Quiz $record) {
                            if (auth()->user()->hasRole('super_admin')) {
                                // if super_admin, hide action
                                return true;
                            } else {
                                // if filament_user, show action
                                // handle if user is currently already attempting the quiz

                                $existingAttempt = QuizAttempt::where([
                                    'quiz_id' => $record->id,
                                    'participant_id' => Auth::id(),
                                ])->first();

                                if ($existingAttempt == null) {
                                    return true;
                                } else {
                                    // hide 
                                    return false;
                                }
                            }
                        }
                    ),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TopicsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            QuizOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
            'attempt' => Pages\AttemptQuiz::route('/{record}/attempt/{quizQuestion}'),
            'result' => Pages\ViewQuiz::route('/{record}/result'),
        ];
    }
}
