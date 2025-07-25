<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\BarangResource\RelationManagers;
use Filament\Forms\Components\FileUpload;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Barang';
    protected static ?string $label = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_barang')
                    ->hiddenOn('create')
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true),
                TextInput::make('nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),
                Select::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->label('Kategori'),
                Select::make('satuan_id')
                    ->relationship('satuan', 'nama_satuan')
                    ->label('Satuan'),
                TextInput::make('stok')
                    ->label('Stok')
                    ->required()
                    ->numeric(),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255),
                FileUpload::make('gambar')
                    ->label('Gambar Barang')
                    ->image()
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_barang')
                    ->label('Kode Barang')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('satuan.nama_satuan')
                    ->label('Satuan'),
                BadgeColumn::make('stok')
                    ->colors([
                        'danger' => fn($state): bool => $state < 5,
                        'warning' => fn($state): bool => $state >= 5 && $state < 10,
                        'success' => fn($state): bool => $state >= 10,
                    ]),
            ])
            ->filters([
                SelectFilter::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->label('Kategori'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
