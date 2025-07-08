<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletResource\RelationManagers\WalletTransactionsRelationManager;
use App\Filament\Resources\WalletResource\Pages;
use App\Filament\Resources\WalletResource\RelationManagers;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Attributes\On;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('merchant_id')
                ->label('Merchant')
                ->relationship('merchant', 'name')
                ->required()
                ->reactive()
                ->afterStateUpdated(function (Set $set, $state) {
                    $merchant = \App\Models\Merchant::find($state);
                    $set('balance', $merchant?->airtime_balance ?? 0);
                }),

                TextInput::make('balance')
                ->label('Merchant Balance')
                ->disabled()
                ->dehydrated(false)
                ->visible(fn (string $context) => $context !== 'create'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('merchant.name')
                ->label('Merchant Name')
                ->searchable()
                ->sortable(),
                
                // TextColumn::make('merchant.airtime_balance')
                // ->label('Merchant Balance')
                // ->money('LSL')
                // ->sortable(),

                TextColumn::make('balance')
                ->label('Balance')
                ->money('LSL'),

                

                TextColumn::make('created_at')
                ->label('Created')
                ->dateTime('d M Y'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            WalletTransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            'edit' => Pages\EditWallet::route('/{record}/edit'),
        ];
    }
    
}

