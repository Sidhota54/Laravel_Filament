<?php

namespace App\Filament\Resources\TagResource\RelationManagers;

use Closure;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Card::make()->schema([
                    Select::make('category_id')
                     ->relationship('category', 'name'),
                    Toggle::make('is_published'),
                ]),
                Card::make()->schema([
                    TextInput::make('title')->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })->required(),
                    TextInput::make('slug')->required(),
                ]),
                Card::make()->schema([
                    RichEditor::make('content'),
                ]),
                Card::make()->schema([
                    FileUpload::make('thumbnali')
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->sortable(),
                TextColumn::make("title")->limit('50')->sortable(),
                TextColumn::make("slug")->limit('50'),
                ToggleColumn::make('is_published'),
                ImageColumn::make('thumbnali')->height(50)
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()->preloadRecordSelect(),
                // Tables\Actions\DeleteAction::make(),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),

            ]);
    }
}
