<?php

declare(strict_types=1);

namespace App\Filament\Resources\Videos;

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\Pages\EditVideo;
use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Models\Video;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

/**
 * Filament admin resource for YouTube video embeds. Only the video ID is
 * stored; thumbnails come from YouTube (requirements 5.4).
 */
class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    /**
     * The create/edit form schema.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('youtube_video_id')
                    ->required()
                    ->label('YouTube video ID')
                    ->helperText('The 11-character ID from the video URL, e.g. dQw4w9WgXcQ.'),
                Textarea::make('description')->columnSpanFull(),
                DateTimePicker::make('published_at'),
            ]);
    }

    /**
     * The listing table.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('youtube_video_id')->label('Video ID')->searchable(),
                TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Related-resource managers (none yet).
     *
     * @return array<class-string>
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Route → page mapping for the resource.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListVideos::route('/'),
            'create' => CreateVideo::route('/create'),
            'edit' => EditVideo::route('/{record}/edit'),
        ];
    }
}
