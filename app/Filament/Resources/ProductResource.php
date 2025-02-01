<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use App\Models\AttributeOption;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\ProductResource\Pages;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Product Basic')
                        ->schema(self::getProductBasic()),
                    Wizard\Step::make('Product Variant')
                        ->schema([
                            Repeater::make('variants') // Use the relationship name
                                ->relationship() // Automatically detects the relationship
                                ->schema(self::getProductVariant()) // Define the schema for variants
                        ]),
                    Wizard\Step::make('Product Meta')
                        ->schema(self::getMetaInformation()),
                ])->columnSpanFull(),
            ]);
    }

    public static function getProductBasic(): array
    {
        return [
            TextInput::make('name')->label("Product Name")->rules(['required']),

            SelectTree::make('category_id')
                ->relationship('category', 'name', 'parent_id')->label("Category")->rules(['required']),

            Select::make('brand_id')->options(Brand::all()->pluck('name', 'id'))->label("Brand")->rules(['required']),

            FileUpload::make('thumbnail')->image()->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string) str($file->getClientOriginalName())->prepend(time() . '-');
            })->directory('thumbnail')->imageEditor()->deletable(true)->rules(['required']),

            FileUpload::make('images')->multiple()->previewable(true)->image()->panelLayout('grid')->label("Product Image")->directory('product-image'),

            RichEditor::make('description')->rules(['required']),
        ];
    }

    public static function getProductVariant(): array
    {

        return [
            TextInput::make('sku'),
            TextInput::make('price')->numeric()->rules(['required']),
            TextInput::make('discount_price')->numeric(),
            TextInput::make('quantity')->numeric(),

            Repeater::make('options')
                ->relationship()
                ->schema([

                    Select::make('attribute_id')
                        ->label('Attribute')
                        ->options(Attribute::all()->pluck('name', 'id'))
                        ->reactive()
                        ->required()
                        ->afterStateHydrated(function ($component, $state, $record) {
                            if ($record && $record->attributeOption) {
                                $component->state($record->attributeOption->attribute_id);
                            }
                        }),

                    Select::make('attribute_option_id')
                        ->label('Option')
                        ->options(function (callable $get) {
                            $attributeId = $get('attribute_id');
                            if (!$attributeId) {
                                return [];
                            }
                            return AttributeOption::where('attribute_id', $attributeId)->pluck('value', 'id');
                        })
                        ->required()
                ])
        ];
    }

    public static function getMetaInformation(): array
    {

        return [
            TextInput::make('meta_title')->label("Meta Title"),
            Textarea::make('meta_description')->label("Meta Description"),
            TagsInput::make('meta_keywords')->label('Meta Keywords'),
        ];
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
