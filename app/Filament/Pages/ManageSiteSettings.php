<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Admin page for editing site-wide settings.
 *
 * A single form rather than a key/value CRUD (KISS) — right now it exposes the
 * "available for new projects" toggle that the static hero used to hardcode
 * (requirements FR8). New settings get added here as the site needs them.
 *
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 40;

    protected static ?string $title = 'Site settings';

    /**
     * Livewire-bound form state.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];

    /**
     * Only authenticated admins may reach this page (CLAUDE.md Section 18).
     */
    public static function canAccess(): bool
    {
        return auth()->check();
    }

    /**
     * Load current setting values into the form when the page opens.
     */
    public function mount(): void
    {
        $aboutImage = Setting::get('about_image');
        $this->form->fill([
            'available_for_projects' => Setting::get('available_for_projects') === '1',
            'about_image' => $aboutImage ? [$aboutImage] : [],
        ]);
    }

    /**
     * The settings form schema.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Global Configuration')
                    ->description('Manage site-wide settings and general information.')
                    ->schema([
                        Toggle::make('available_for_projects')
                            ->label('Available for new projects')
                            ->helperText('Controls the availability badge shown in the site hero.'),
                        
                        FileUpload::make('about_image')
                            ->label('About Profile Image')
                            ->image()
                            ->imageEditor()
                            ->maxSize(4096)
                            ->disk('public')
                            ->directory('settings')
                            ->helperText('This image is displayed on the About page. Defaults to profile.png if not uploaded.'),
                    ])
                    ->columns(1)
            ])
            ->statePath('data');
    }

    /**
     * Persist the submitted settings.
     */
    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('available_for_projects', ! empty($data['available_for_projects']) ? '1' : '0');

        $aboutImage = $data['about_image'] ?? null;
        if (is_array($aboutImage)) {
            $aboutImage = reset($aboutImage) ?: null;
        }
        Setting::set('about_image', $aboutImage);

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    /**
     * The save button rendered beneath the form.
     *
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }
}
