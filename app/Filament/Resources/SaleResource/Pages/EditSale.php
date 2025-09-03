<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-printer')
                ->url(fn ($record) => route('sales.export.pdf', $record))

                ->openUrlInNewTab(),
        ];
    }
}
