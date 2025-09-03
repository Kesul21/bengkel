<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_all_pdf')
                ->label('Export Semua PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->url(route('sales.export.all.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
