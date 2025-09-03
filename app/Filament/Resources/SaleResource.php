<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;


class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Penjualan Sparepart';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')->required(),
                Forms\Components\Select::make('customer_id')
                    ->label('Pelanggan')
                    ->relationship('customer', 'nama')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->label('Daftar Barang')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'nama')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('harga_satuan', Product::find($state)?->harga ?? 0)),

                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                    ])
                    ->columns(3),

                Forms\Components\TextInput::make('total')
                    ->label('Total Bayar')
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->default(0)
                    ->afterStateHydrated(function ($component, $record) {
                        if ($record) {
                            $component->state(
                                $record->items->sum(fn ($item) => $item->qty * $item->harga_satuan)
                            );
                        }
                    }),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y'),
                Tables\Columns\TextColumn::make('customer.nama')->label('Pelanggan'),
                Tables\Columns\TextColumn::make('total')->money('IDR', locale: 'id'),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu Input')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\ViewAction::make(),
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
    // Tambahkan di sini:
    Tables\Actions\Action::make('cetak'),
                ]),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
