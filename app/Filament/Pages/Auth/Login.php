<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;

class Login extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.auth.login';
}
