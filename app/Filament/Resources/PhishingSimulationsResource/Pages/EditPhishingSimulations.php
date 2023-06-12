<?php

namespace App\Filament\Resources\PhishingSimulationsResource\Pages;

use App\Filament\Resources\PhishingSimulationsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhishingSimulations extends EditRecord
{
    protected static string $resource = PhishingSimulationsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
