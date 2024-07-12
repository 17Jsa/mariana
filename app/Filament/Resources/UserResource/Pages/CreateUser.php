<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): User
    {
        
        $user = User::create($data);

        if (isset($data['roles']) && !empty($data['roles'])) {
            $user->roles()->attach($data['roles']);
        }

        return $user;
    }
    protected function redirectAfterSave(): string
    {
        return $this->getResource()::route('index');
    }
}
