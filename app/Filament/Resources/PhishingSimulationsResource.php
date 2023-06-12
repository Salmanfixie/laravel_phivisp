<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhishingSimulationsResource\Pages;
use App\Filament\Resources\PhishingSimulationsResource\RelationManagers;
use App\Filament\Resources\PhishingSimulationsResource\RelationManagers\VictimsRelationManager;
use App\Models\DummyWebsite;
use App\Models\PhishingSimulations;
use App\Models\PhishingVictims;
use App\Models\TemplatePhishingSimulation;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\URL;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Symfony\Contracts\Service\Attribute\Required;

class PhishingSimulationsResource extends Resource
{
    protected static ?string $model = PhishingSimulations::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Simulation';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([

                Section::make(__('General'))
                    ->schema([

                        TextInput::make('name')->required()
                            ->label('Simulation Name'),

                        Select::make('simulation_type')
                            ->options([
                                'maybank_phishing_email' => 'Maybank phishing email',
                                'ecomm_phishing_email' => 'UMP E-comm phishing email',
                            ])
                            ->required()
                            ->searchable()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state === 'maybank_phishing_email') {
                                    $set('phishing_link', URL::to("/maybank"));
                                } else if ($state === 'ecomm_phishing_email') {
                                    $set('phishing_link', URL::to("/ump"));
                                }
                            }),

                        TextInput::make('phishing_link')
                            ->required()
                            ->disabled(),

                        Textarea::make('purpose')->required(),

                        Select::make('target_audience')
                            ->options([
                                'employees' => 'Employees',
                                'students' => 'Students',
                                'random_users' => 'Random Users',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('num_of_victim')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(30),

                        Toggle::make('is_sent')
                            ->label(__('Sent'))
                            ->required()
                            ->onIcon('heroicon-s-lightning-bolt')
                            ->offIcon('heroicon-s-lightning-bolt')
                            ->default(false)
                            ->inline(false)
                            ->disabled()
                            ->hidden(),

                        FileUpload::make('media_url')
                            ->disk('simulation')
                            ->image()
                            // 12 mb
                            ->maxSize(12000)
                            ->required()
                            ->label(__('Image'))
                            ->placeholder(__('Upload Simulation Image Here'))
                            ->imageCropAspectRatio('18:9')
                            ->imageResizeTargetWidth('720')
                            ->imageResizeTargetHeight('350'),

                    ])->columns(1),

                Section::make(__('Additional'))
                    ->schema([

                        FileUpload::make('attachment_path')
                            ->disk('simulation')
                            ->maxSize(12288) // Set the maximum file size in kilobytes
                            ->label(__('Attachment'))
                            ->placeholder(__('Upload File Attachment Here')),

                        Textarea::make('feedback'),

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
                    ->disk('simulation')
                    ->extraImgAttributes([
                        'title' => 'Simulation Image',
                    ]),

                TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable()
                    ->weight('medium')
                    ->limit(50),

                TextColumn::make('is_sent')
                    ->label(__('Sent'))
                    ->weight('medium')
                    ->limit(50)
                    ->getStateUsing(function ($record) {
                        if (!$record->is_sent && !$record->is_completed) {
                            return __('Not started');
                        } elseif ($record->is_sent && !$record->is_completed) {
                            return __('In progress');
                        } elseif ($record->is_sent && $record->is_completed) {
                            return __('Completed');
                        }
                    }),


                TextColumn::make('victim_count')
                    ->getStateUsing(function ($record) {
                        $victims = PhishingVictims::where([
                            'phishing_simulations_id' => $record->id,
                        ])->count();
                        return $victims . ' victims';
                    })
                    ->icon('heroicon-o-collection'),

                Panel::make([
                    TextColumn::make('purpose')
                        ->sortable()
                        ->searchable()
                        ->size('sm'),
                ])->collapsible(),
            ])
            ->filters([

                Filter::make('Completed')
                    ->default(false)
                    ->query(fn (Builder $query): Builder => $query->where('is_sent', true)),

                Filter::make('In progress')
                    ->default(false)
                    ->query(fn (Builder $query): Builder => $query->where('is_sent', false))

            ])
            ->actions([

                Tables\Actions\Action::make('Send Phishing Email')
                    ->label('Send Phishing Email')
                    ->action(function (PhishingSimulations $record) {

                        $victims = PhishingVictims::where('phishing_simulations_id', $record->id)->get();

                        if (!$victims->isEmpty()) {

                            $victims->each(function ($victim) use ($record) {

                                if ($record->simulation_type == 'maybank_phishing_email') {
                                    $email_subject = 'Maybank Alert: Important Security Update';
                                    $phishing_company = 'Maybank Berhad';
                                } else if ($record->simulation_type == 'ecomm_phishing_email') {
                                    $email_subject = 'UMP E-Community Alert: Important Security Update';
                                    $phishing_company = 'Universiti Malaysia Pahang';
                                }
                                $email = new \App\Mail\PhishingEmail($record->phishing_link, $victim->name, $victim->phone_no, $victim->company, $email_subject, $phishing_company);
                                \Illuminate\Support\Facades\Mail::to($victim->email)->send($email);
                            });

                            $victimsCount = $victims->count();

                            $record->update(['is_sent' => true]);

                            $notification = Notification::make()
                                ->title('Emails sent successfully')
                                ->body("Emails have been sent to {$victimsCount} victims.")
                                ->success();
                        } else {

                            $notification = Notification::make()
                                ->title('No victims found')
                                ->body('There are no victims for the simulation.')
                                ->danger();
                        }

                        $notification->send();
                        return redirect()->back();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-play')
                    ->color('primary')
                    ->hidden(function (?Model $record) {
                        if ($record && $record->is_sent) {
                            // Hide the button if the `is_sent` attribute is `true`
                            return true;
                        }
                        // Show the button if the `is_sent` attribute is `false` or null
                        return false;
                    }),

                Tables\Actions\Action::make('Send Feedback Email')
                    ->label('Send Feedback Email')
                    ->action(function (PhishingSimulations $record) {

                        $victims = PhishingVictims::where('phishing_simulations_id', $record->id)->get();

                        if (!$victims->isEmpty()) {

                            $victims->each(function ($victim) use ($record) {

                                if ($record->simulation_type == 'maybank_phishing_email') {
                                    $email_subject = 'Maybank Phishing Simulation Exercise - Your Attention Required';
                                    $phishing_email_subject = 'Maybank Alert: Important Security Update';
                                    $phishing_company = 'Maybank Berhad';
                                } else if ($record->simulation_type == 'ecomm_phishing_email') {
                                    $email_subject = 'UMP E-Community Phishing Simulation Exercise - Your Attention Required';
                                    $phishing_email_subject = 'UMP E-Community Alert: Important Security Update';
                                    $phishing_company = 'Universiti Malaysia Pahang';
                                }

                                $feedback_link = URL::to("/feedback");

                                $email = new \App\Mail\EducateEmail($feedback_link, $victim->name, $email_subject, $phishing_email_subject, $phishing_company);
                                \Illuminate\Support\Facades\Mail::to($victim->email)->send($email);
                            });

                            $victimsCount = $victims->count();

                            $record->update(['is_completed' => true]);

                            $notification = Notification::make()
                                ->title('Emails sent successfully')
                                ->body("Emails have been sent to {$victimsCount} victims.")
                                ->success();
                        } else {

                            $notification = Notification::make()
                                ->title('No victims found')
                                ->body('There are no victims for the simulation.')
                                ->danger();
                        }

                        $notification->send();
                        return redirect()->back();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-academic-cap')
                    ->color('primary')
                    ->hidden(function (?Model $record) {
                        if ($record && $record->is_sent && !$record->is_completed) {
                            // Show the button if the `is_sent` attribute is `true` and `is_completed` is `false`
                            return false;
                        }
                        // Hide the button for any other cases
                        return true;
                    }),

                Tables\Actions\ViewAction::make()
                    ->label('View details')
                    ->icon('heroicon-o-eye')
                    ->hidden(
                        function () {
                            if (auth()->user()->hasRole('super_admin')) {
                                // if super_admin, hide action
                                return true;
                            } else {
                                // if filament_user, show action
                                return false;
                            }
                        }
                    ),

                Tables\Actions\EditAction::make()
                    ->color('warning'),

                Tables\Actions\Deleteaction::make(),

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
            VictimsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhishingSimulations::route('/'),
            'create' => Pages\CreatePhishingSimulations::route('/create'),
            'edit' => Pages\EditPhishingSimulations::route('/{record}/edit'),
            'view' => Pages\ViewPhishingSimulations::route('/{record}'),
        ];
    }
}
