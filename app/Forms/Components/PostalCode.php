<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;

class PostalCode extends TextInput //será por text input
{
    public function viaCep(
        string $errorMessage = 'CEP inválido.',
        array $setFields = []
    ) : static {
        $viaCepRequest = function (
            $state,
            $livewire, 
            $set,
            $component, 
            string $errorMessage,
            array $setFields
        ) {}
        $this
            ->mask('99999-999')
            ->minLength(9)
            ->maxLength(9)
            ->suffixAction(
                Action::make('search-action')
                    ->label('Buscar CEP')
                    ->icon('heroicon-o-magnifying-glass')//from https://heroicons.com/
            );
        return $this;
    }
}
