<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Widgets\QuestionOverview;
use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Filament\Resources\QuestionResource\RelationManagers\OptionsRelationManager;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Harishdurga\LaravelQuiz\Models\Question as ModelsQuestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;

class QuestionResource extends Resource
{
    protected static ?string $model = ModelsQuestion::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Quiz';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Grid::make(1)
                        ->schema([

                            Textarea::make('name')->required()->label('Question'),

                            FileUpload::make('image_path')
                                ->disk('question')
                                ->image()
                                // 12 mb
                                ->maxSize(12000)
                                ->label(__('Image'))
                                ->placeholder(__('Upload Question Image Here'))
                                ->imageCropAspectRatio('18:9')
                                ->imageResizeTargetWidth('720')
                                ->imageResizeTargetHeight('350'),

                            Toggle::make('is_active')
                                ->onIcon('heroicon-s-lightning-bolt')
                                ->offIcon('heroicon-s-lightning-bolt')
                                ->default(true)
                                ->inline(false),

                        ]),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')->sortable()->searchable()->limit(80)->label('Question'),

                TextColumn::make('topics.name')->label('Topic')->alignCenter(),

                BooleanColumn::make('is_active')->label('Status')->alignCenter(),

            ])

            ->filters([
                Filter::make('Active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),

                Filter::make('Inactive')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OptionsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            QuestionOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
