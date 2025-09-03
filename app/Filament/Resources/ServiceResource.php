<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Riwayat Servis';
    protected static ?string $pluralModelLabel = 'Riwayat Servis';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('customer_id')
                ->label('Customer')
                ->relationship('customer', 'nama')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('motor')
                ->label('Jenis Motor')
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal Servis')
                ->required(),

            Forms\Components\TextInput::make('biaya_jasa')
                ->label('Biaya Jasa')
                ->numeric()
                ->default(0)
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $get) {
                    $set('total_bayar', (int) ($get('total_sparepart') ?? 0) + (int) ($get('biaya_jasa') ?? 0));
                }),

            Forms\Components\Repeater::make('details')
    ->label('Sparepart Digunakan')
    ->relationship('details')
    ->schema([
        Forms\Components\Select::make('product_id')
            ->label('Produk')
            ->options(Product::all()->pluck('nama', 'id'))
            ->searchable()
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $product = Product::find($state);
                if ($product) {
                    $set('harga_satuan', $product->harga);
                    $qty = $get('qty') ?? 0;
                    $set('subtotal', $qty * $product->harga);
                }
            }),

        Forms\Components\TextInput::make('qty')
            ->label('Jumlah')
            ->numeric()
            ->default(1)
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $harga = (int) $get('harga_satuan');
                $set('subtotal', $state * $harga);
            }),

        Forms\Components\TextInput::make('harga_satuan')
            ->label('Harga Satuan')
            ->numeric()
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $qty = (int) $get('qty');
                $set('subtotal', $qty * $state);
            }),

        Forms\Components\TextInput::make('subtotal')
            ->label('Subtotal')
            ->numeric()
            ->readOnly()
            ->required(), // ✅ WAJIB karena field ini NOT NULL
    ])
    ->columns(4)
    ->afterStateUpdated(function (callable $set, $get) {
        $total = 0;
        foreach ($get('details') ?? [] as $detail) {
            $total += (int) ($detail['subtotal'] ?? 0);
        }
        $set('total_sparepart', $total);
        $set('total_bayar', $total + (int) ($get('biaya_jasa') ?? 0));
    }),


            Forms\Components\TextInput::make('total_sparepart')
                ->label('Total Sparepart')
                ->numeric()
                ->readOnly(),

            Forms\Components\TextInput::make('total_bayar')
                ->label('Total Bayar')
                ->numeric()
                ->readOnly(),
        ]);
    }
    public static function updateTotalSparepart(callable $set, callable $get): void
{
    $total = 0;
    foreach ($get('details') ?? [] as $detail) {
        $qty = (int) ($detail['qty'] ?? 0);
        $harga = (int) ($detail['harga'] ?? 0);
        $total += $qty * $harga;
    }

    $set('total_sparepart', $total);
    $set('total_bayar', $total + (int) ($get('biaya_jasa') ?? 0));
}

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('customer.nama')->label('Customer')->searchable(),
                 Tables\Columns\TextColumn::make('motor'),
                  Tables\Columns\TextColumn::make('tanggal')->date(),
                   Tables\Columns\TextColumn::make('biaya_jasa')->money('IDR'),
                    Tables\Columns\TextColumn::make('total_sparepart')->money('IDR'),
                     Tables\Columns\TextColumn::make('total_bayar')->money('IDR'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
