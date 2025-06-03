<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirtimeVoucherResource\Pages;
use App\Filament\Resources\AirtimeVoucherResource\RelationManagers;
use App\Models\AirtimeVoucher;
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


class AirtimeVoucherResource extends Resource
{
    protected static ?string $model = AirtimeVoucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        TextInput::make('code')
            ->label('Voucher Code')
            ->required()
            ->unique(ignoreRecord: true),

        Select::make('denomination')
            ->options([
                '5' => 'M5',
                '10' => 'M10',
                '20' => 'M20',
                '50' => 'M50',
                '100' => 'M100',
            ])
            ->required(),

        Select::make('status')
            ->options([
                'available' => 'Available',
                'assigned' => 'Assigned',
                'sold' => 'Sold',
            ])
            ->default('available'),

        Select::make('agent_id')
            ->relationship('agent', 'user.name')
            ->searchable()
            ->nullable()
            ->label('Assigned Agent'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAirtimeVouchers::route('/'),
            'create' => Pages\CreateAirtimeVoucher::route('/create'),
            'edit' => Pages\EditAirtimeVoucher::route('/{record}/edit'),
        ];
    }
}
