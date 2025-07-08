<?php

namespace App\Filament\Resources\WalletResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\CreateAction;


class WalletTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';
    // protected static ?string $refreshTarget = 'record';


    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'credit' => 'Credit',
                        'debit' => 'Debit',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')->numeric()->required(),
                Forms\Components\TextInput::make('reason')->required(),
                Forms\Components\TextInput::make('reference'),
                Forms\Components\Textarea::make('meta')->json(),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
         return $table
        ->columns([
            TextColumn::make('reference'),
            TextColumn::make('type'),
            TextColumn::make('amount')->money('LSL'),
            TextColumn::make('reason'),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->headerActions([
            CreateAction::make(), // ✅ shows the "Create" button
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $wallet = $this->ownerRecord;

        if ($data['type'] === 'debit') {
            if ($wallet->balance < $data['amount']) {
                throw ValidationException::withMessages([
                    'amount' => 'Insufficient wallet balance.',
                ]);
            }

            $wallet->balance -= $data['amount'];
        } else {
            $wallet->balance += $data['amount'];
        }

        $wallet->save(); // ✅ THIS IS CRITICAL

        return $data;
    }

    // protected function afterCreate(): void
    // {
    //     $transaction = $this->getRecord();

    //     $wallet = $transaction->wallet;
    //     $merchant = $wallet->merchant;

    //     if ($transaction->type === 'credit') {
    //         $merchant->balance += $transaction->amount;
    //     } elseif ($transaction->type === 'debit') {
    //         if ($merchant->balance < $transaction->amount) {
    //             throw new \Exception('Insufficient merchant balance.');
    //         }
    //         $merchant->balance -= $transaction->amount;
    //     }

    //     $merchant->save();
        
    //     $this->ownerRecord->refresh(); // refresh wallet
    //     $this->dispatch('$refresh');   // refresh UI
    // }


}
