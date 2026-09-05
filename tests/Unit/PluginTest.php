<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Tests\Unit;

use Noreviq\FilamentTheme\Enums\AuthStyle;
use Noreviq\FilamentTheme\Enums\CornerStyle;
use Noreviq\FilamentTheme\Enums\ShadowStyle;
use Noreviq\FilamentTheme\NoreviqThemePlugin;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PluginTest extends TestCase
{
    #[Test]
    public function it_has_stable_publishable_defaults(): void
    {
        $plugin = new NoreviqThemePlugin;

        self::assertSame('noreviq-filament-theme', $plugin->getId());
        self::assertSame(CornerStyle::Sharp, $plugin->getCornerStyle());
        self::assertSame(ShadowStyle::Balanced, $plugin->getShadowStyle());
        self::assertSame(AuthStyle::Noreviq, $plugin->getAuthStyle());
    }

    #[Test]
    public function it_exposes_only_typed_supported_options(): void
    {
        $plugin = (new NoreviqThemePlugin)
            ->corners(CornerStyle::Native)
            ->shadows(ShadowStyle::Elevated)
            ->authStyle(AuthStyle::Native);

        self::assertSame(CornerStyle::Native, $plugin->getCornerStyle());
        self::assertSame(ShadowStyle::Elevated, $plugin->getShadowStyle());
        self::assertSame(AuthStyle::Native, $plugin->getAuthStyle());
        self::assertFalse(method_exists($plugin, 'colors'));
        self::assertFalse(method_exists($plugin, 'primaryColor'));
    }

    #[Test]
    public function every_option_has_a_stable_asset_safe_value(): void
    {
        self::assertSame(['sharp', 'subtle', 'native'], array_column(CornerStyle::cases(), 'value'));
        self::assertSame(['flat', 'balanced', 'elevated'], array_column(ShadowStyle::cases(), 'value'));
        self::assertSame(['noreviq', 'native'], array_column(AuthStyle::cases(), 'value'));
    }
}
