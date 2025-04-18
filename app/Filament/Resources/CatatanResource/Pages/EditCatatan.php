<?php

namespace App\Filament\Resources\CatatanResource\Pages;

use App\Filament\Resources\CatatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatatan extends EditRecord
{
    protected static string $resource = CatatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
