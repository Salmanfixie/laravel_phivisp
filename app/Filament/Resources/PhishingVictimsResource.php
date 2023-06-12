<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhishingVictimsResource\Pages;
use App\Filament\Resources\PhishingVictimsResource\RelationManagers;
use App\Models\PhishingSimulations;
use App\Models\PhishingVictims;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class PhishingVictimsResource extends Resource
{
    protected static ?string $model = PhishingVictims::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

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

                            TextInput::make('phone_no')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->email()
                                ->maxLength(255),

                            TextInput::make('company')
                                ->required()
                                ->maxLength(255),

                            Select::make('phishing_simulations_id')
                                ->label('Phishing simulation')
                                ->options(PhishingSimulations::pluck('name', 'id')->toArray())
                                ->required()
                                ->disabled(),

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
                TextColumn::make('phone_no')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('company')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListPhishingVictims::route('/'),
            'create' => Pages\CreatePhishingVictims::route('/create'),
            'edit' => Pages\EditPhishingVictims::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
