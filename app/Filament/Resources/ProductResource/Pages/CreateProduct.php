<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\Concerns\HasWizard;

class CreateProduct extends CreateRecord
{
    use HasWizard;
    protected static string $resource = ProductResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Product Basic')
                ->schema(ProductResource::getProductBasic()),

            Step::make('Product Variant')
                ->schema([
                    Repeater::make('variants')
                        ->relationship()
                        ->schema(ProductResource::getProductVariant())
                ]),

            Step::make('Product Meta')
                ->schema(ProductResource::getMetaInformation()),
        ];
    }
}
