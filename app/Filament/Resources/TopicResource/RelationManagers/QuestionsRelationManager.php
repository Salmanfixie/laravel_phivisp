<?php

namespace App\Filament\Resources\TopicResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('question')
                    ->label('Question Details')
                    ->schema([

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

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

                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->limit(80),
                BooleanColumn::make('is_active')->label('Status')->alignCenter(),
            ])
            ->filters([])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()->label('Attach question'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
