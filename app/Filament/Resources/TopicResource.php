<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopicResource\Pages;
use App\Filament\Resources\TopicResource\RelationManagers;
use App\Filament\Resources\TopicResource\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\TopicResource\Widgets\StatsOverview;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\Filter;
use Harishdurga\LaravelQuiz\Models\Topic as ModelsTopic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopicResource extends Resource
{
    protected static ?string $model = ModelsTopic::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Quiz';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Grid::make(1)
                        ->schema([

                            Forms\Components\TextInput::make('name')->required(),

                            Forms\Components\TextInput::make('slug')->required(),

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
                
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Topic'),

                Tables\Columns\TextColumn::make('slug'),

                BooleanColumn::make('is_active')->label('Status')->alignCenter(),

            ])
            ->defaultSort(column: 'updated_at', direction: 'desc')
            ->filters([
                Filter::make('Active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),

                Filter::make('Inactive')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false))
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
            QuestionsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopics::route('/'),
            'edit' => Pages\EditTopic::route('/{record}/edit'),
        ];
    }
}
