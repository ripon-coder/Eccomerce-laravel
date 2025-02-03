<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use PhpOption\None;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                SelectTree::make('parent_id')
                    ->label('Select Parent Category')
                    ->relationship('parent', 'name', 'parent_id')
                    ->searchable()
                    ->enableBranchNode(),

                Forms\Components\TextInput::make('name')
                    ->label("Category Name")
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('slug')
                    ->label("Slug")
                    ->required()
                    ->maxLength(255)
                    ->unique('categories', 'slug', ignoreRecord: true)
                    ->regex('/^[a-z0-9-]+$/')
                    ->afterStateUpdated(function ($state, $set) {
                        $set('slug', Str::slug(strtolower($state)));
                    })
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
