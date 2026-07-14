<?php

declare(strict_types=1);

namespace App\Filament\Resources\Leads;

use App\Enums\LeadStatus;
use App\Filament\Resources\Leads\Pages\EditLead;
use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Filament\Resources\Leads\Pages\ViewLead;
use App\Models\Lead;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

/**
 * Filament admin resource for contact-form leads.
 *
 * Effectively read-only (requirements FR7): leads are created by the public
 * form, not in the admin, and only the pipeline `status` is editable here so
 * Ohene can track follow-up. Create/delete are blocked by LeadPolicy.
 */
class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|UnitEnum|null $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 30;

    /**
     * Surface the count of new (un-actioned) leads on the nav item (Section 18).
     */
    public static function getNavigationBadge(): ?string
    {
        $new = static::getModel()::query()
            ->where('status', LeadStatus::New)
            ->count();

        return $new > 0 ? (string) $new : null;
    }

    /**
     * Colour the new-leads badge to read as actionable.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    /**
     * Edit form — deliberately limited to the follow-up status only.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->options(LeadStatus::class)
                    ->default(LeadStatus::New)
                    ->required(),
            ]);
    }

    /**
     * Read-only detail view of the submitted lead.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')->label('Email address')->copyable(),
                TextEntry::make('status')->badge(),
                TextEntry::make('message')->columnSpanFull(),
                TextEntry::make('project_type')->badge()->placeholder('-'),
                TextEntry::make('budget_range')->badge()->placeholder('-'),
                TextEntry::make('utm_source')->placeholder('-'),
                TextEntry::make('utm_medium')->placeholder('-'),
                TextEntry::make('utm_campaign')->placeholder('-'),
                TextEntry::make('referrer')->placeholder('-'),
                TextEntry::make('created_at')->dateTime()->label('Submitted'),
            ]);
    }

    /**
     * The listing table.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->label('Email address')->searchable(),
                TextColumn::make('project_type')->badge(),
                TextColumn::make('budget_range')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime()->label('Submitted')->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->label('Update status'),
            ])
            ->emptyStateHeading('No leads yet')
            ->emptyStateDescription('When a potential client fills out the contact form, their lead will appear here.')
            ->emptyStateIcon(Heroicon::OutlinedInbox);
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
     * Route → page mapping. No create route: leads only arrive via the site.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListLeads::route('/'),
            'view' => ViewLead::route('/{record}'),
            'edit' => EditLead::route('/{record}/edit'),
        ];
    }
}
