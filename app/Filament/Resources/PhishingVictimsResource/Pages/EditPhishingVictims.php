<?php

namespace App\Filament\Resources\PhishingVictimsResource\Pages;

use App\Filament\Resources\PhishingVictimsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhishingVictims extends EditRecord
{
    protected static string $resource = PhishingVictimsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
