<?php

namespace App\Filament\Company\Clusters\Settings\Resources\CurrencyResource\Pages;

use App\Concerns\HandlesResourceRecordCreation;
use App\Filament\Company\Clusters\Settings\Resources\CurrencyResource;
use App\Models\Setting\Currency;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateCurrency extends CreateRecord
{
    use HandlesResourceRecordCreation;

    protected static string $resource = CurrencyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['enabled'] = (bool) $data['enabled'];

        return $data;
    }

    /**
     * @throws Halt
     */
    protected function handleRecordCreation(array $data): Model
    {
        $user = Auth::user();

        if (! $user) {
            throw new Halt('No authenticated user found');
        }

        return $this->handleRecordCreationWithUniqueField($data, new Currency(), $user);
    }
}
