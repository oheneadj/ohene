<?php

declare(strict_types=1);

namespace App\Filament\Resources\Videos;

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\Pages\EditVideo;
use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Models\Video;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
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

    protected static string|UnitEnum|null $navigationGroup = 'Blog & Media';

    protected static ?int $navigationSort = 20;

    /**
     * The create/edit form schema.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Group::make()->schema([
                        Section::make('Video Content')
                            ->schema([
                                TextInput::make('title')
                                    ->placeholder('e.g. Building a Laravel App from Scratch')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->placeholder('e.g. In this video, we cover...')
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    Group::make()->schema([
                        Section::make('Settings')
                            ->schema([
                                TextInput::make('youtube_video_id')
                                    ->placeholder('e.g. dQw4w9WgXcQ')
                                    ->required()
                                    ->label('YouTube Video ID')
                                    ->helperText('The 11-character ID from the video URL, e.g. dQw4w9WgXcQ.'),
                                DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->helperText('When this video should appear on the site.'),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 1]),
                ])->columnSpanFull(),
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
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No videos yet')
            ->emptyStateDescription('Add a YouTube video to feature it on your site.')
            ->emptyStateIcon(Heroicon::OutlinedVideoCamera);
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
