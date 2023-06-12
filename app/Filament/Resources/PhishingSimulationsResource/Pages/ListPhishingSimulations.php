<?php

namespace App\Filament\Resources\PhishingSimulationsResource\Pages;

use App\Filament\Resources\PhishingSimulationsResource\Widgets\PhishingSimulationsOverview;
use App\Filament\Resources\PhishingSimulationsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhishingSimulations extends ListRecords
{
    protected static string $resource = PhishingSimulationsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PhishingSimulationsOverview::class,
        ];
    }

    
}
