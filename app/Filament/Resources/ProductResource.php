<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms\Form;
use App\Models\Attribute;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\AttributeOption;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\ProductResource\Pages;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
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
                            Repeater::make('variants')
                                ->relationship()
                                ->schema(self::getProductVariant())
                                ->columns(2)
                                ->defaultItems(1)
                                ->collapsed()
                                ->cloneable()
                                ->reorderableWithButtons()
                                ->itemLabel(fn(array $state): ?string => $state['sku'] ?? null)
                                ->minItems(1)

                        ]),
                    Wizard\Step::make('Product Meta')
                        ->schema(self::getMetaInformation()),
                ])->columnSpanFull(),
            ]);
    }

    public static function getProductBasic(): array
    {
        return [
            TextInput::make('name')->label("Product Name")->required(),

            TextInput::make('slug')
                ->label("Slug")
                ->required()
                ->maxLength(255)
                ->unique('products', 'slug', ignoreRecord: true)
                ->regex('/^[a-z0-9-]+$/')
                ->afterStateUpdated(function ($state, $set) {
                    $set('slug', Str::slug(strtolower($state)));
                }),

            SelectTree::make('category_id')->required()
                ->relationship('category', 'name', 'parent_id')->label("Category")->rules(['required']),

            Select::make('brand_id')->required()->options(Brand::all()->pluck('name', 'id'))->label("Brand")->rules(['required']),

            FileUpload::make('thumbnail')->image()->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                return (string) str($file->getClientOriginalName())->prepend(time() . '-');
            })->directory('thumbnail')->imageEditor()->deletable(true)->rules(['required']),

            FileUpload::make('images')->multiple()->previewable(true)->image()->panelLayout('grid')->label("Product Image")->directory('product-image'),

            RichEditor::make('description')->rules(['required']),

            Toggle::make('is_published'),
            Toggle::make('feature_product'),
        ];
    }

    public static function getProductVariant(): array
    {

        return [
            TextInput::make('sku'),
            TextInput::make('price')->numeric()->required(),
            TextInput::make('discount_price')->numeric(),
            TextInput::make('quantity')->numeric()->required(),
            TextInput::make('weight')->label("Weight(kg)")->numeric(),

            Repeater::make('options')
                ->relationship()
                ->schema([

                    Select::make('attribute_id')
                        ->label('Attribute')
                        ->options(Attribute::all()->pluck('name', 'id'))
                        ->reactive()
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
                ])->columns(2)->minItems(1)->columnSpanFull()
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
                Tables\Columns\TextColumn::make('id')->label("ID")->searchable()->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                ImageColumn::make('thumbnail')
                    ->square(),

                Tables\Columns\TextColumn::make('slug')
                    ->copyable()
                    ->copyableState(fn(Product $record): string => config('app.url') . '/product/' . $record->slug)
                    ->size(TextColumnSize::ExtraSmall),

                Tables\Columns\TextColumn::make('category.name')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('brand.name')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\IconColumn::make('feature_product')->boolean(),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc');
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
