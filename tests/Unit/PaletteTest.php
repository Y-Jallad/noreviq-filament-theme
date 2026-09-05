<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Tests\Unit;

use Noreviq\FilamentTheme\Support\Palette;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PaletteTest extends TestCase
{
    #[Test]
    public function it_defines_every_filament_semantic_color(): void
    {
        self::assertSame(
            ['primary', 'gray', 'danger', 'info', 'success', 'warning'],
            array_keys(Palette::all()),
        );
    }

    #[Test]
    public function it_uses_distinct_teal_primary_and_green_success_palettes(): void
    {
        self::assertSame('#2dd4bf', Palette::primary()[400]);
        self::assertSame('#0f766e', Palette::primary()[600]);
        self::assertSame('#042f2e', Palette::primary()[950]);
        self::assertSame('#16a34a', Palette::success()[600]);
        self::assertNotSame(Palette::primary()[600], Palette::success()[600]);
    }

    #[Test]
    public function every_palette_contains_all_required_shades(): void
    {
        $expectedShades = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];

        foreach (Palette::all() as $palette) {
            self::assertSame($expectedShades, array_keys($palette));

            foreach ($palette as $color) {
                self::assertMatchesRegularExpression('/^#[0-9a-f]{6}$/i', $color);
            }
        }
    }
}
