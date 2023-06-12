<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Simulation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Card::make([
                    Grid::make(1)
                        ->schema([

                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->email()
                                ->maxLength(255),

                            TextInput::make('comments')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('rating')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('improvement')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('created_at')
                                ->required()
                                ->maxLength(255),

                        ]),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('comments')
                    ->alignCenter()
                    ->wrap()
                    ->searchable(),

                    TextColumn::make('rating')
                    ->alignCenter()
                    ->wrap()
                    ->sortable()
                    ->searchable(),

                    TextColumn::make('improvement')
                    ->alignCenter()
                    ->wrap()
                    ->searchable(),

            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }
}
