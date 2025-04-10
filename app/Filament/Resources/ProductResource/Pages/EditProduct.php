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

    // public function beforeSave()
    // {
    //     $thumbnail = $this->data['thumbnail'] ?? null;
    //     $oldThumbnail = $this->record->thumbnail;

    //     $images = $this->data['images'] ?? [];
    //     $oldImages = $this->record->images ?? [];

    //     if ($oldThumbnail && (empty($thumbnail) || $thumbnail)) {
    //         Storage::disk('public')->delete($oldThumbnail);
    //     }

    //     // Find images that were removed
    //     $deletedImages = array_diff($oldImages, $images);

    //     // Delete only the removed images
    //     foreach ($deletedImages as $deletedImage) {
    //         Storage::disk('public')->delete($deletedImage);
    //     }

    //     $this->record->thumbnail = $thumbnail;
    //     $this->record->images = $images;
    // }
    public function beforeSave()
    {
        // Retrieve the new and old thumbnail and images
        $newThumbnail = isset($this->data['thumbnail']) && is_array($this->data['thumbnail']) ? reset($this->data['thumbnail']) : null;
        $oldThumbnail = $this->record->thumbnail;
        $newImages = $this->data['images'] ?? [];
        $oldImages = $this->record->images ?? [];
    
        // ✅ Only delete the old thumbnail if a new thumbnail is set and different from the old one
        if ($oldThumbnail && $newThumbnail && $newThumbnail != $oldThumbnail) {
            Storage::disk('public')->delete($oldThumbnail);
        }
    
        // ✅ Only delete removed images from the array
        $deletedImages = array_diff($oldImages, $newImages);
        foreach ($deletedImages as $deletedImage) {
            Storage::disk('public')->delete($deletedImage);
        }
    
        // ✅ Assign the new thumbnail and images to the record (whether changed or not)
        $this->record->thumbnail = $newThumbnail;
        $this->record->images = $newImages;
    }
    
    
}
