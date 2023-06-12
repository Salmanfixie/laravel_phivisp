<?php

namespace App\Filament\Resources\PhishingVictimsResource\Pages;

use App\Filament\Resources\PhishingVictimsResource\Widgets\PhishingVictimsOverview;
use App\Filament\Resources\PhishingVictimsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhishingVictims extends ListRecords
{
    protected static string $resource = PhishingVictimsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PhishingVictimsOverview::class,
        ];
    }

}
