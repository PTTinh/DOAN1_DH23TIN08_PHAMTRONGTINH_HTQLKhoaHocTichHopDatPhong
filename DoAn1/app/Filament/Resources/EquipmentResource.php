<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Thuê phòng học';

    public static function getModelLabel(): string
    {
        return 'thiết bị';
    }
    public static function getPluralModelLabel(): string
    {
        return 'thiết bị';
    }
    public static function getNavigationLabel(): string
    {
        return 'Trang thiết bị';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin thiết bị')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên thiết bị')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(2),                    
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null) // Vô hiệu hóa click để chỉnh sửa
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên thiết bị')
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Người tạo')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // 
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Sửa')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên thiết bị')
                            ->required()
                            ->maxLength(100),
                    ])
                    ->modalWidth('md'),

                Tables\Actions\DeleteAction::make()
                    ->label('Xóa'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa các mục đã chọn'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Thêm thiết bị đầu tiên')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên thiết bị')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('created_by')
                            ->label('Người tạo')
                            ->default(Auth::id())
                            ->hidden(),
                    ])
                    ->modalWidth('md')
                    ->createAnother(false),
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
            'index' => Pages\ListEquipment::route('/'),
        ];
    }
}
