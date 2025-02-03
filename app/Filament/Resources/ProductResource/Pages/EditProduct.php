<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProductResource;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function beforeSave()
    {
        $thumbnail = $this->data['thumbnail'] ?? null;
        $oldThumbnail = $this->record->thumbnail;

        $images = $this->data['images'] ?? [];
        $oldImages = $this->record->images ?? [];

        if ($oldThumbnail && (empty($thumbnail) || $thumbnail)) {
            Storage::disk('public')->delete($oldThumbnail);
        }

        // Find images that were removed
        $deletedImages = array_diff($oldImages, $images);

        // Delete only the removed images
        foreach ($deletedImages as $deletedImage) {
            Storage::disk('public')->delete($deletedImage);
        }


    }
}
