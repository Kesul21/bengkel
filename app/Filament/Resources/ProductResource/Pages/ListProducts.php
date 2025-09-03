<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_all_pdf')
    ->label('Export Semua Produk')
    ->icon('heroicon-o-printer')
    ->url(route('products.export.pdf'))
    ->openUrlInNewTab(),
        ];
    }
}
