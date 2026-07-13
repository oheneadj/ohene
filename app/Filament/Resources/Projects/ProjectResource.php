<?php

declare(strict_types=1);

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

/**
 * Filament admin resource for case studies / portfolio work.
 *
 * Grouped into content, media/links, display and SEO sections so the form
 * stays scannable (CLAUDE.md Section 18). Authorization is delegated to
 * ProjectPolicy — Filament respects it automatically.
 */
class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 10;

    /**
     * The create/edit form schema.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->schema([
                        TextInput::make('title')
                            ->placeholder('e.g. Acme E-commerce Rebuild')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set): void {
                                $set('slug', Str::slug((string) $state));
                                $set('cover_image_alt', $state);
                            }),
                        TextInput::make('slug')
                            ->placeholder('e.g. acme-ecommerce-rebuild')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Locked after publish to protect indexed URLs.'),
                        TextInput::make('tagline')
                            ->placeholder('e.g. A modern headless storefront')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('challenge')
                            ->placeholder('e.g. The client was struggling with slow load times...')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('build')
                            ->placeholder('e.g. We architected a Next.js frontend...')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('impact')
                            ->placeholder('e.g. 40% increase in conversion rate.')
                            ->required()
                            ->helperText('State a quantified outcome wherever real data exists.')
                            ->columnSpanFull(),
                        TagsInput::make('tech_stack')
                            ->placeholder('Laravel, MySQL, Vue.js')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Media & links')
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->imageEditor()
                            // Auto-crop/resize to a fixed 16:9 on upload so the design can't
                            // break, no matter the source file (FR10 / req 4.3).
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->maxSize(4096)
                            ->disk('public')
                            ->directory('projects'),
                        TextInput::make('cover_image_alt')
                            ->label('Cover image alt text')
                            ->placeholder('e.g. Screenshot of the Acme homepage')
                            ->maxLength(255)
                            ->requiredWith('cover_image')
                            ->helperText('Required whenever a cover image is set (accessibility, req 4.2).'),
                        TextInput::make('live_url')->placeholder('e.g. https://acme.com')->url(),
                        TextInput::make('repo_url')->placeholder('e.g. https://github.com/oheneadj/acme')->url(),
                        FileUpload::make('gallery')
                            ->multiple()
                            ->reorderable()
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('projects/gallery')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Display')
                    ->schema([
                        Toggle::make('featured')
                            ->helperText('Show this project in the Home page preview.'),
                        TextInput::make('display_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->placeholder('e.g. Acme E-commerce Case Study')
                            ->maxLength(255),
                        TextInput::make('meta_description')
                            ->placeholder('e.g. Read how we rebuilt the Acme storefront...')
                            ->maxLength(255),
                        FileUpload::make('og_image')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('630')
                            ->maxSize(4096)
                            ->disk('public')
                            ->directory('projects/og')
                            ->helperText('Falls back to the cover image when left blank. Resized to 1200×630 for social sharing.'),
                    ])->columns(2)->collapsed(),
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
                TextEntry::make('slug'),
                TextEntry::make('tagline'),
                TextEntry::make('challenge')->columnSpanFull(),
                TextEntry::make('build')->columnSpanFull(),
                TextEntry::make('impact')->columnSpanFull(),
                TextEntry::make('tech_stack')->badge(),
                ImageEntry::make('cover_image')->disk('public')->placeholder('-'),
                TextEntry::make('live_url')->placeholder('-'),
                TextEntry::make('repo_url')->placeholder('-'),
                IconEntry::make('featured')->boolean(),
                TextEntry::make('display_order')->numeric(),
            ]);
    }

    /**
     * The listing table.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('display_order')
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('tech_stack')->badge(),
                IconColumn::make('featured')->boolean(),
                TextColumn::make('display_order')->numeric()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'view' => ViewProject::route('/{record}'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
