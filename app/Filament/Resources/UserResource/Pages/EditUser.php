<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function redirectAfterSave(): string
    {
        return $this->getResource()::route('index');
    }
    
    public function beforeMount($record)
    {
        $user = User::findOrFail($record);

        $this->record = $user->toArray();
    }
    
    
}
