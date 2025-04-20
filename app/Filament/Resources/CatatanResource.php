<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatatanResource\Pages;
use App\Filament\Resources\CatatanResource\RelationManagers;
use App\Models\Catatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatatanResource extends Resource
{
    protected static ?string $model = Catatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('content')->required(),
                Forms\Components\DatePicker::make('date')->required(),
                Forms\Components\TimePicker::make('time')->required(),
                Forms\Components\FileUpload::make('image_path')->label('Image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('date'),
                Tables\Columns\TextColumn::make('time'),
            ])
            ->filters([
                //
])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCatatans::route('/'),
            'create' => Pages\CreateCatatan::route('/create'),
            'edit' => Pages\EditCatatan::route('/{record}/edit'),
        ];
    }
}
