<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentColor;
use Noreviq\FilamentTheme\Enums\AuthStyle;
use Noreviq\FilamentTheme\Enums\CornerStyle;
use Noreviq\FilamentTheme\Enums\ShadowStyle;
use Noreviq\FilamentTheme\Support\Palette;

final class NoreviqThemePlugin implements Plugin
{
    private const ASSET_PACKAGE = 'noreviq/filament-theme';

    private CornerStyle $cornerStyle = CornerStyle::Sharp;

    private ShadowStyle $shadowStyle = ShadowStyle::Balanced;

    private AuthStyle $authStyle = AuthStyle::Noreviq;

    public static function make(): static
    {
        return app(self::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'noreviq-filament-theme';
    }

    public function corners(CornerStyle $style): static
    {
        $this->cornerStyle = $style;

        return $this;
    }

    public function shadows(ShadowStyle $style): static
    {
        $this->shadowStyle = $style;

        return $this;
    }

    public function authStyle(AuthStyle $style): static
    {
        $this->authStyle = $style;

        return $this;
    }

    public function getCornerStyle(): CornerStyle
    {
        return $this->cornerStyle;
    }

    public function getShadowStyle(): ShadowStyle
    {
        return $this->shadowStyle;
    }

    public function getAuthStyle(): AuthStyle
    {
        return $this->authStyle;
    }

    public function register(Panel $panel): void
    {
        $assets = [
            Css::make('noreviq-theme', $this->assetPath('noreviq.css')),
            Css::make(
                "noreviq-corners-{$this->cornerStyle->value}",
                $this->assetPath("presets/corners-{$this->cornerStyle->value}.css"),
            ),
            Css::make(
                "noreviq-shadows-{$this->shadowStyle->value}",
                $this->assetPath("presets/shadows-{$this->shadowStyle->value}.css"),
            ),
        ];

        if ($this->authStyle === AuthStyle::Noreviq) {
            $assets[] = Css::make('noreviq-auth', $this->assetPath('noreviq-auth.css'));
        }

        $panel
            ->assets($assets, self::ASSET_PACKAGE)
            ->colors(Palette::all());
    }

    public function boot(Panel $panel): void
    {
        // Panel colors are registered before plugins boot. Registering the fixed
        // palette here makes Noreviq the final semantic palette for this panel.
        FilamentColor::register(Palette::all());
    }

    private function assetPath(string $path): string
    {
        return __DIR__."/../resources/dist/{$path}";
    }
}
