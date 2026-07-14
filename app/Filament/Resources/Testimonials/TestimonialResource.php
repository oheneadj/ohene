<?php

declare(strict_types=1);

namespace App\Filament\Resources\Testimonials;

use App\Enums\TestimonialStatus;
use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
 * Filament admin resource for client testimonials.
 *
 * Everything defaults to pending; only when Ohene flips a testimonial to
 * approved does it become eligible for the public site (requirements 5.3).
 */
class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static ?string $recordTitleAttribute = 'client_name';

    protected static string|UnitEnum|null $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 10;

    /**
     * The create/edit form schema.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Group::make()->schema([
                        Section::make('Client Details')
                            ->schema([
                                TextInput::make('client_name')
                                    ->placeholder('e.g. Jane Doe')
                                    ->required(),
                                TextInput::make('role')
                                    ->placeholder('e.g. Chief Marketing Officer'),
                                TextInput::make('company')
                                    ->placeholder('e.g. Acme Corp')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Section::make('Content')
                            ->schema([
                                Textarea::make('quote')
                                    ->placeholder('e.g. Ohene delivered an exceptional product...')
                                    ->required()
                                    ->rows(6)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['sm' => 3, 'lg' => 2]),

                    Group::make()->schema([
                        Section::make('Status & Assignment')
                            ->schema([
                                Select::make('status')
                                    ->options(TestimonialStatus::class)
                                    ->default(TestimonialStatus::Pending)
                                    ->required(),
                                Select::make('project_id')
                                    ->relationship('project', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->label('Linked project'),
                            ]),

                        Section::make('Avatar')
                            ->schema([
                                FileUpload::make('avatar')
                                    ->image()
                                    ->avatar()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('300')
                                    ->imageResizeTargetHeight('300')
                                    ->maxSize(2048)
                                    ->disk('public')
                                    ->directory('testimonials')
                                    ->columnSpanFull(),
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
            ->columns([
                TextColumn::make('client_name')->searchable()->sortable(),
                TextColumn::make('company')->searchable(),
                TextColumn::make('project.title')->label('Project')->placeholder('-'),
                TextColumn::make('status')->badge(),
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
            ->emptyStateHeading('No testimonials yet')
            ->emptyStateDescription('Add a testimonial to showcase client feedback.')
            ->emptyStateIcon(Heroicon::OutlinedChatBubbleBottomCenterText);
    }

    /**
     * Surface the count of testimonials awaiting approval on the nav item.
     */
    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::query()
            ->where('status', TestimonialStatus::Pending)
            ->count();

        return $pending > 0 ? (string) $pending : null;
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
