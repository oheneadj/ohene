<?php

declare(strict_types=1);

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ Content')
                    ->description('The question and answer pair displayed on the contact page.')
                    ->schema([
                        TextInput::make('question')
                            ->placeholder('e.g. How much does a website cost?')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('answer')
                            ->placeholder('e.g. It depends on the scope of the project...')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['sm' => 2, 'md' => 2]),

                Section::make('Display Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Whether this FAQ should be visible on the site.')
                            ->default(true)
                            ->required(),
                        TextInput::make('display_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.')
                            ->required(),
                    ])
                    ->columnSpan(['sm' => 2, 'md' => 1]),

            ])->columns(3);
    }
}
