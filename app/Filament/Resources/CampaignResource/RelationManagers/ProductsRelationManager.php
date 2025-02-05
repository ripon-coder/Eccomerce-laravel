<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Repeater::make('products')
                ->schema([

                    Select::make('product_id')
                    ->label('Product')
                    ->allowHtml()
                    ->searchable()
                    ->options(function () {
                        return Product::where('is_published', true)
                            ->get()
                            ->mapWithKeys(function (Product $product) {
                                $thumbnailUrl = asset($product->thumbnail); // Full URL
                                $html = "
                                    <div class='flex items-center gap-2'>
                                        <img 
                                            src='{$thumbnailUrl}' 
                                            alt='{$product->name}' 
                                            class='h-8 w-8 rounded'
                                        />
                                        <span>{$product->name} (ID: {$product->id})</span>
                                    </div>
                                ";
                
                                return [$product->id => $html];
                            });
                    })
                    ->getSearchResultsUsing(function (string $search) {
                        return Product::where('name', 'like', "%{$search}%")
                            ->where('is_published', true)
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function (Product $product) {
                                $thumbnailUrl = asset($product->thumbnail); // Full URL
                                $html = "
                                    <div class='flex items-center gap-2'>
                                        <img 
                                            src='{$thumbnailUrl}' 
                                            alt='{$product->name}' 
                                            class='h-8 w-8 rounded'
                                        />
                                        <span>{$product->name} (ID: {$product->id})</span>
                                    </div>
                                ";
                
                                return [$product->id => $html];
                            });
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $product = Product::find($value);
                        $thumbnailUrl = asset($product->thumbnail); // Full URL
                
                        return "
                            <div class='flex items-center gap-2'>
                                <img 
                                    src='{$thumbnailUrl}' 
                                    alt='{$product->name}' 
                                    class='h-6 w-6 rounded'
                                />
                                <span>{$product->name} (ID: {$product->id})</span>
                            </div>
                        ";
                    })
                    ->required(),

                    TextInput::make('max_quantity')
                        ->label('Max Quantity')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required(),
                ])
                ->columnSpanFull()


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
