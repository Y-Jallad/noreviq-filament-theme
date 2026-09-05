<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Tests\Integration;

use Filament\Enums\ThemeMode;
use Filament\Panel;
use Filament\Support\Assets\Asset;
use Filament\Support\Colors\Color;
use Filament\Support\Colors\ColorManager;
use Noreviq\FilamentTheme\Enums\AuthStyle;
use Noreviq\FilamentTheme\Enums\CornerStyle;
use Noreviq\FilamentTheme\Enums\ShadowStyle;
use Noreviq\FilamentTheme\NoreviqThemePlugin;
use Noreviq\FilamentTheme\Support\Palette;
use Noreviq\FilamentTheme\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use ReflectionProperty;

final class PanelIntegrationTest extends TestCase
{
    #[Test]
    public function it_registers_only_the_assets_selected_for_the_panel(): void
    {
        $panel = (new Panel)->id('admin');
        $plugin = (new NoreviqThemePlugin)
            ->corners(CornerStyle::Subtle)
            ->shadows(ShadowStyle::Elevated)
            ->authStyle(AuthStyle::Native);

        $plugin->register($panel);

        self::assertSame(
            ['noreviq-theme', 'noreviq-corners-subtle', 'noreviq-shadows-elevated'],
            $this->assetIds($panel),
        );
        self::assertSame(Palette::all(), $panel->getColors());
    }

    #[Test]
    public function it_registers_the_noreviq_auth_asset_by_default(): void
    {
        $panel = (new Panel)->id('admin');

        (new NoreviqThemePlugin)->register($panel);

        self::assertSame(
            ['noreviq-theme', 'noreviq-corners-sharp', 'noreviq-shadows-balanced', 'noreviq-auth'],
            $this->assetIds($panel),
        );
    }

    #[Test]
    public function it_does_not_change_structural_panel_configuration(): void
    {
        $panel = (new Panel)
            ->id('admin')
            ->brandName('Consumer brand')
            ->brandLogo('/brand.svg')
            ->favicon('/favicon.svg')
            ->font('Consumer Sans')
            ->darkMode(false)
            ->defaultThemeMode(ThemeMode::Dark)
            ->maxContentWidth('screen-xl')
            ->sidebarWidth('18rem')
            ->collapsedSidebarWidth('5rem')
            ->sidebarCollapsibleOnDesktop()
            ->topNavigation();

        (new NoreviqThemePlugin)->register($panel);

        self::assertSame('Consumer brand', $panel->getBrandName());
        self::assertSame('/brand.svg', $panel->getBrandLogo());
        self::assertSame('/favicon.svg', $panel->getFavicon());
        self::assertSame('Consumer Sans', $panel->getFontFamily());
        self::assertFalse($panel->hasDarkMode());
        self::assertSame(ThemeMode::Dark, $panel->getDefaultThemeMode());
        self::assertSame('screen-xl', $panel->getMaxContentWidth());
        self::assertSame('18rem', $panel->getSidebarWidth());
        self::assertSame('5rem', $panel->getCollapsedSidebarWidth());
        self::assertTrue($panel->isSidebarCollapsibleOnDesktop());
        self::assertTrue($panel->hasTopNavigation());
    }

    #[Test]
    public function it_restores_the_fixed_palette_after_consumer_panel_colors(): void
    {
        $panel = (new Panel)->id('admin');
        $plugin = new NoreviqThemePlugin;

        $panel
            ->plugin($plugin)
            ->colors(['primary' => Color::Red]);

        $panel->boot();

        $registrations = (new ReflectionProperty(ColorManager::class, 'colors'))
            ->getValue($this->app->make(ColorManager::class));

        self::assertSame(Palette::all(), $registrations[array_key_last($registrations)]);
    }

    /** @return array<int, string> */
    private function assetIds(Panel $panel): array
    {
        $assets = (new ReflectionProperty(Panel::class, 'assets'))->getValue($panel);

        self::assertArrayHasKey('noreviq/filament-theme', $assets);

        return array_map(
            static fn (Asset $asset): string => $asset->getId(),
            $assets['noreviq/filament-theme'],
        );
    }
}
