<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Motor Pelanggan';
    protected static ?string $navigationGroup = 'Master Service';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Pemilik')
                    ->relationship('customer', 'nama')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('no_polisi')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('merk')->required(),
                Forms\Components\TextInput::make('tipe')->required(),
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(date('Y'))
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_polisi')->searchable(),
                Tables\Columns\TextColumn::make('merk'),
                Tables\Columns\TextColumn::make('tipe'),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('customer.nama')->label('Pemilik'),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
