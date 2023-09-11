<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Pages\Page;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;


class EditProfile extends BaseEditProfile
{
    protected static string $view = 'filament.pages.auth.edit-profile';

    protected static string $layout= 'filament-panels::components.layout.index';

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public static function getSlug(): string
    {
        return static::$slug ?? 'me';
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Informations')
                    ->aside()
                    ->schema([
                    $this->getNameFormComponent(),
                    $this->getDocumentFormComponent(),
                    $this->getEmailFormComponent(),
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                ])
            ]);
    }

    protected function getDocumentFormComponent(): Component
    {
        return TextInput::make('document')
            ->label(__('CPF'))
            ->mask('999.999.999-99')
            //->disabled() fica apenas pra visualização
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }
}
