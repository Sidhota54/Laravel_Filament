<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label(__('Save & Create Another'))
            ->action('createAnother')
            ->keyBindings(['mod+shift+s'])
            ->color('primary');
    }
}
