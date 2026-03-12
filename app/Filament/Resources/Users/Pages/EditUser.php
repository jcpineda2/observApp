<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->visible(fn(): bool => static::getResource()::canDelete($this->record)),

            Action::make('updatePassword')
                ->label('Cambiar contraseña')
                ->schema([
                    TextInput::make('password')
                ])
            // action::make('cambiar_contraseña')
            //     ->label('Cambiar Contraseña')
            //     ->form(self::contraseñaForm())
            //     ->visible(function (User $record){
            //         return Gate::allows('cambiarContrasena', $record);
            //     })
            //     ->action(function ($data) {
            //         $user = User::where('id', $this->record->id)->first();

            //         if ($data['password'] == $data['repeated_password']) {
            //             $user->update([
            //                 'password' => bcrypt($data['password'])
            //             ]);

            //             Notification::make()
            //                 ->title('Contraseña Actualizada!')
            //                 ->success()
            //                 ->send();
            //         }
            //         else{

            //             Notification::make()
            //                 ->title('Las contraseñas no coinciden')
            //                 ->warning()
            //                 ->send();

            //                 $this->halt(); // Detiene la acción y mantiene el modal abierto
            //                 return;
            //         }
            //     })
            //     ->modalWidth(MaxWidth::FourExtraLarge)
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}
