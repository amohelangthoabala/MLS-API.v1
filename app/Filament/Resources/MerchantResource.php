<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchantResource\Pages;
use App\Filament\Resources\MerchantResource\RelationManagers;
use App\Models\Merchant;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Tabs;
//use Filament\Forms\Components\Tab;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

        //     ->schema([
        //     Tabs::make('Merchant Form')
        //         ->tabs([
        //             Tab::make('Details')
        //                 ->schema([
        //                     TextInput::make('name')->required(),
        //                     TextInput::make('code')->required()->unique(),
        //                     // Add other merchant fields here
        //                     Forms\Components\Select::make('type')
        //                         ->options(['merchant' => 'Merchant', 'agent' => 'Agent'])
        //                         ->required(),
        //                     Forms\Components\TextInput::make('airtime_balance')
        //                         ->numeric()
        //                         ->prefix('M')
        //                         ->default(0),

        //                     MultiSelect::make('users')
        //                         ->label('User')
        //                         ->relationship('users', 'name') // 'name' is the column in the users table
        //                         ->searchable()
        //                         ->preload()
        //                         ->required(), // optional


        //                 ]),

        //         Tab::make('Products')
        //                 ->schema([
        //                     MultiSelect::make('products')
        //                         ->label('Assigned Products')
        //                         ->relationship('products', 'name')
        //                         ->searchable()
        //                         ->preload()
        //                         ->helperText('Select which products this merchant can sell'),
        //                 ]),
        //         ]),
        // ]);
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('code')->required()->unique(),
                Forms\Components\Select::make('type')
                ->options(['merchant' => 'Merchant', 'agent' => 'Agent'])
                ->required(),
                Forms\Components\TextInput::make('airtime_balance')
                ->numeric()
                ->prefix('M')
                ->default(0),

                MultiSelect::make('users')
                ->label('User')
                ->relationship('users', 'name') // 'name' is the column in the users table
                ->searchable()
                ->preload()
                ->required(), // optional

                Select::make('products')
                ->label('Assigned Products')
                ->multiple()
                ->relationship('products', 'name')
                ->searchable()
                ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('type'),
                TextColumn::make('users_list')
                ->label('User')
                ->getStateUsing(function ($record) {
                    return $record->users->pluck('name');
                }),
                Tables\Columns\TextColumn::make('airtime_balance')->money('LSL'),
                BadgeColumn::make('products.name')
                ->label('Products')
                // ->colors(['primary'])
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
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        // Example role check — adjust based on your logic
        // if ($user->hasRole('super_admin')) {
        //     return parent::getEloquentQuery();
        // }

        return parent::getEloquentQuery()
            ->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
    }

}
