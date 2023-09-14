<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;

class PostalCode extends TextInput //serrá por text input
{
    protected string $view = 'forms.components.postal-code';
}
