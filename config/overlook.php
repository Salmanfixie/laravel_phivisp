<?php

use App\Filament\Resources\QuestionResource;
use App\Filament\Resources\QuizResource;
use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\TopicResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\DummyWebsiteResource;
use App\Filament\Resources\PhishingSimulationsResource;
use App\Filament\Resources\PhishingVictimsResource;
use App\Filament\Resources\PhishingDataResource;
use Discoverlance\FilamentPageHints\Resources\PageHintsResource;

return [
    'includes' => [
        QuestionResource::class,
        TopicResource::class,
        QuizResource::class,
        PageHintsResource::class,
        RoleResource::class,
    ],
    'excludes' => [],

];
