<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select, Toggle, Textarea, KeyValue};
use Filament\Tables\Columns\{TextColumn, BooleanColumn};
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->required(),
                Select::make('type')
                    ->label('Product Type')
                    ->options([
                        'airtime' => 'Airtime',
                        'electricity' => 'Electricity',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state === 'electricity') {
                            $set('provider_text', 'L.E.C');
                            $set('provider', 'L.E.C');
                        } else {
                            $set('provider_text', null);
                            $set('provider', null);
                        }
                    }),



                Select::make('provider_select')
                    ->label('Provider')
                    ->options([
                        'ETL' => 'ETL',
                        'VCL' => 'VCL',
                    ])
                    ->reactive()
                    ->required(fn (callable $get) => $get('type') === 'airtime')
                    ->visible(fn (callable $get) => $get('type') === 'airtime')
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('provider', $state);
                    }),

                TextInput::make('provider_text')
                    ->label('Provider')
                    ->disabled()
                    ->visible(fn (callable $get) => $get('type') === 'electricity'),

                Hidden::make('provider')
                    ->required(),


                Select::make('denominations')
                    ->label('Denominations (Airtime)')
                    ->multiple()
                    ->options([
                        'M5' => 'M5',
                        'M10' => 'M10',
                        'M20' => 'M20',
                        'M50' => 'M50',
                        'M100' => 'M100',
                    ])
                    ->visible(fn (callable $get) => $get('type') === 'airtime')
                    ->required(fn (callable $get) => $get('type') === 'airtime')
                    // ->saveAsJson()
                    ->dehydrated(true)
                    ->reactive(),

                TextInput::make('denominations_text')
                    ->label('Denominations (Electricity)')
                    ->helperText('Enter values like M50,M100,M200')
                    ->visible(fn (callable $get) => $get('type') === 'electricity')
                    ->required(fn (callable $get) => $get('type') === 'electricity')
                    ->afterStateHydrated(function ($component, $state) {
                        if (is_array($state)) {
                            $component->state(implode(',', $state));
                        }
                    })
                    ->dehydrated()
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(',', $state) : $state),



                Toggle::make('is_available')->label('Available'),

                TextInput::make('agent_commission')
                    ->label("Agent's Cut (%)")
                    ->numeric()
                    ->required(),

                TextInput::make('mls_commission')
                    ->label("MLS's Cut (%)")
                    ->numeric()
                    ->required(),

                TextInput::make('balance')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->searchable(),
                TextColumn::make('type'),
                TextColumn::make('provider'),
                
                BadgeColumn::make('denominations')
                    ->label('Denominations')
                    ->getStateUsing(fn ($record) => is_array($record->denominations) 
                        ? $record->denominations 
                        : (is_string($record->denominations) 
                            ? json_decode($record->denominations, true) ?? [] 
                            : [])
                    )
                    ->color('primary')

                    ->separator(', '),
                BooleanColumn::make('is_available')->label('Available'),

                TextColumn::make('agent_commission')->label("Agent's Cut"),

                TextColumn::make('mls_commission')->label("MLS's Cut"),

                TextColumn::make('balance')
                    ->label('Balance (LSL)')
                    ->sortable()
                    ->money('LSL'),
                    // ->prefix('M'),

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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
