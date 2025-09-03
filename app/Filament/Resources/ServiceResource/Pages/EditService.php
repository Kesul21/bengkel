<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Cetak Kwitansi')
            ->label('Cetak Kwitansi')
            ->url(fn () => route('services.print', ['service' => $this->record->id]))
            ->openUrlInNewTab()
            ->icon('heroicon-o-printer'),
        ];
    }
    protected function afterSave(): void
{
    // Hapus dulu sale lama jika perlu
    if ($this->record->sale) {
        $this->record->sale->details()->delete();
        $this->record->sale->delete();
    }

    $this->record->generateSale();
}
}
