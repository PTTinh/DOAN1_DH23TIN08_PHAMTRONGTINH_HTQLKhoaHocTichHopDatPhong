<?php

namespace App\Filament\Resources\EquipmentResource\Pages;

use App\Filament\Resources\EquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;

class ListEquipment extends ListRecords
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Thêm thiết bị')
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên thiết bị')
                        ->required()
                        ->maxLength(100),
                ])
                ->modalWidth('md')
                ->createAnother(false),
        ];
    }
}
