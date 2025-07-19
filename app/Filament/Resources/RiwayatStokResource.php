<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RiwayatStok;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RiwayatStokResource\Pages;
use App\Filament\Resources\RiwayatStokResource\RelationManagers;

class RiwayatStokResource extends Resource
{
    protected static ?string $model = RiwayatStok::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('barang_id')
                    ->relationship('barang', 'nama')
                    ->label('Nama Barang')
                    ->required(),
                Select::make('tipe')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                    ])
                    ->required(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $barangId = $get('barang_id');
                        $tipe = $get('tipe');

                        if ($barangId && $tipe === 'keluar') {
                            $barang = Barang::find($barangId);
                            if ($barang && $state > $barang->stok) {
                                $set('jumlah', $barang->stok);
                                \Filament\Notifications\Notification::make()
                                    ->title('Jumlah melebihi stok')
                                    ->danger()
                                    ->send();
                            }
                        }
                    }),
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->searchable(),
                BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'masuk',
                        'danger' => 'keluar',
                    ]),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListRiwayatStoks::route('/'),
            'create' => Pages\CreateRiwayatStok::route('/create'),
            'edit' => Pages\EditRiwayatStok::route('/{record}/edit'),
        ];
    }
}
