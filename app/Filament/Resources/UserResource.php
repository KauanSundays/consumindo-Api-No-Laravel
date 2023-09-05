<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Closure;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(191),
                Fieldset::make('User Address')
                    ->relationship('userAddress')
                    ->schema([
                        TextInput::make('postal_code')
                        ->label('CEP')
                        ->suffixAction(
                            fn ($state, Closure $set) =>
                                Action::make('search-action')
                                    ->icon('heroicon-o-search')
                                    ->action(function () use ($state, $set) {
                                        if (blank($state)) {
                                            Filament::notify('danger', 'Digite o CEP para buscar o endereço');
                                            return;
                                        }
                    
                                        try {
                                            $cepData = Http::get("https://viacep.com.br/ws/{$state}/json/")
                                                ->throw()
                                                ->json();
                                        } catch (RequestException $e) {
                                            Filament::notify('danger', 'Erro ao buscar o endereço');
                                            return;
                                        }
                    
                                        $set('address_neighborhood', $cepData['bairro'] ?? null);
                                        $set('address', $cepData['logradouro'] ?? null);
                                        $set('city_id', City::where('title', $cepData['localidade'])->first()->id ?? null);
                                        $set('state', State::where('letter', $cepData['uf'])->first()->id ?? null);
                                    })
                        ),
                        TextInput::make('address'),
                        TextInput::make('number'),
                        TextInput::make('complement'),
                        TextInput::make('neighborhood'),
                        TextInput::make('city'),
                        TextInput::make('uf'),
                        // Textarea::make('description'),
                        // FileUpload::make('image'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
