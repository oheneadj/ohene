<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts;

use App\Enums\PostStatus;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Pages\ViewPost;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

/**
 * Filament admin resource for blog posts.
 *
 * The body uses a restricted rich-text toolbar so authors can't inject
 * arbitrary HTML/styles and break the design (requirements 4.3). Read time is
 * derived on the model, so it isn't an editable field here.
 */
class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    /**
     * The create/edit form schema.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)->schema([
                    \Filament\Schemas\Components\Group::make()->schema([
                        Section::make('Content')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $get, callable $set): void {
                                        $set('slug', Str::slug((string) $state));
                                        $set('meta_title', $state);
                                        $set('cover_image_alt', $state);
                                        // Pre-fill excerpt only if it hasn't been set yet
                                        if (empty($get('excerpt'))) {
                                            $set('excerpt', $state);
                                            $set('meta_description', Str::limit((string) $state, 160));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Locked after publish to protect indexed URLs.'),
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull(),
                                Textarea::make('excerpt')
                                    ->maxLength(500)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set): void {
                                        $set('meta_description', Str::limit((string) $state, 160));
                                    })
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Section::make('Media')
                            ->schema([
                                FileUpload::make('cover_image')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->maxSize(4096)
                                    ->disk('public')
                                    ->directory('posts')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set): void {
                                        $set('og_image', $state);
                                    })->columnSpanFull(),
                                TextInput::make('cover_image_alt')
                                    ->label('Cover image alt text')
                                    ->maxLength(255)
                                    ->requiredWith('cover_image')
                                    ->helperText('Required whenever a cover image is set.'),
                            ])->columns(2),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    \Filament\Schemas\Components\Group::make()->schema([
                        Section::make('Publishing & SEO')
                            ->schema([
                                Select::make('status')
                                    ->options(PostStatus::class)
                                    ->default(PostStatus::Draft)
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->helperText('When the post goes (or went) live.'),
                                TextInput::make('meta_title')->maxLength(255),
                                Textarea::make('meta_description')
                                    ->maxLength(255)
                                    ->requiredIf('status', PostStatus::Published->value)
                                    ->helperText('Required before a post can be published.'),
                                FileUpload::make('og_image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('630')
                                    ->maxSize(4096)
                                    ->disk('public')
                                    ->directory('posts/og')
                                    ->helperText('Falls back to the cover image when left blank. Resized to 1200×630.'),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 1]),
                ])->columnSpanFull(),

                Section::make('Post Body')
                    ->schema([
                        RichEditor::make('body')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'h2', 'h3', 'bulletList',
                                'orderedList', 'link', 'blockquote', 'codeBlock',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /**
     * The read-only detail (infolist) schema.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('category.name')->label('Category')->placeholder('-'),
                TextEntry::make('status')->badge(),
                TextEntry::make('read_time')->suffix(' min'),
                TextEntry::make('published_at')->dateTime()->placeholder('-'),
                TextEntry::make('excerpt')->placeholder('-')->columnSpanFull(),
                TextEntry::make('body')->html()->columnSpanFull(),
                ImageEntry::make('cover_image')->disk('public')->placeholder('-'),
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
                TextColumn::make('category.name')->label('Category')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('read_time')->suffix(' min')->sortable(),
                TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'view' => ViewPost::route('/{record}'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
