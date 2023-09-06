<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;


class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
