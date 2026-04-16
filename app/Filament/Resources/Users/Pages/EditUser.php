<?php

namespace App\Filament\Resources\Users\Pages;

use App\Domains\WorkOrders\Filament\Resources\WorkOrders\Pages\EditWorkOrder;
use App\Domains\WorkOrders\Models\WorkOrder;
use App\Filament\Resources\Users\UserResource;
use App\Forms\Components\LinesRepeaterWithoutRelationship;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('updateName')
                ->mountUsing(function (Schema $form, Model $record) {
                    $form->fill([
                        'name' => $record->name,
                    ]);
                })
                ->schema([
                    Select::make('name')
                        ->searchable()
                        ->options([
                            'Name A' => 'Name A',
                            'Name B' => 'Name B',
                            'Name C' => 'Name C',
                        ]),
                ])
                ->action(function (array $data, Model $record) {
                    $record->name = $data['name'];
                    $record->save();
                })
                ->successNotificationTitle('Name updated!')
                ->successRedirectUrl(function (Model $record) {
                    return static::getUrl(['record' => $record]);
                }),
            DeleteAction::make(),
        ];
    }
}
