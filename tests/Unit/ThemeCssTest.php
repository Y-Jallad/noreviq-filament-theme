<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class ThemeCssTest extends TestCase
{
    private string $coreCss;

    private string $allSourceCss;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coreCss = $this->read('resources/dist/noreviq.css');
        $sourceFiles = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->packagePath('resources/css/src')),
        );
        $sources = [];
        $sourceRoot = $this->packagePath('resources/css/src');

        foreach ($sourceFiles as $file) {
            if ($file instanceof SplFileInfo && $file->isFile() && $file->getExtension() === 'css') {
                $relativePath = substr($file->getPathname(), strlen($sourceRoot) + 1);

                $sources[] = $this->read('resources/css/src/'.str_replace('\\', '/', $relativePath));
            }
        }

        $this->allSourceCss = implode("\n", $sources);
    }

    #[Test]
    public function it_builds_every_runtime_asset(): void
    {
        $assets = [
            'resources/dist/noreviq.css',
            'resources/dist/noreviq-auth.css',
            'resources/dist/presets/corners-sharp.css',
            'resources/dist/presets/corners-subtle.css',
            'resources/dist/presets/corners-native.css',
            'resources/dist/presets/shadows-flat.css',
            'resources/dist/presets/shadows-balanced.css',
            'resources/dist/presets/shadows-elevated.css',
        ];

        foreach ($assets as $asset) {
            self::assertFileExists($this->packagePath($asset));
            self::assertStringContainsString('Noreviq Filament Theme v1.0.0', $this->read($asset));
        }
    }

    #[Test]
    public function it_keeps_the_fixed_teal_graphite_identity(): void
    {
        self::assertStringContainsString('--noreviq-canvas: #f4f7f7', $this->coreCss);
        self::assertStringContainsString('--noreviq-sidebar: #0d2a2d', $this->coreCss);
        self::assertStringContainsString('--noreviq-canvas: #101516', $this->coreCss);
        self::assertStringContainsString('--noreviq-surface: #182022', $this->coreCss);
        self::assertStringContainsString('--noreviq-sidebar: #0a2426', $this->coreCss);
        self::assertStringContainsString('--noreviq-primary: var(--primary-600)', $this->coreCss);
        self::assertStringNotContainsString('#6c5d80', strtolower($this->allSourceCss));
        self::assertStringNotContainsString('#9483ad', strtolower($this->allSourceCss));
    }

    #[Test]
    public function corner_presets_cover_filament_and_noreviq_tokens(): void
    {
        foreach (['sharp', 'subtle', 'native'] as $preset) {
            $css = $this->read("resources/dist/presets/corners-{$preset}.css");

            foreach (['control', 'card', 'overlay', 'pill', 'toggle', 'toggle-handle'] as $token) {
                self::assertStringContainsString("--noreviq-radius-{$token}:", $css);
            }

            foreach (['sm', 'md', 'lg', 'xl'] as $token) {
                self::assertStringContainsString("--radius-{$token}:", $css);
            }
        }
    }

    #[Test]
    public function shadow_presets_preserve_focus_and_surface_boundaries(): void
    {
        foreach (['flat', 'balanced', 'elevated'] as $preset) {
            $css = $this->read("resources/dist/presets/shadows-{$preset}.css");

            foreach (['surface', 'action', 'raised', 'overlay', 'shell'] as $token) {
                self::assertStringContainsString("--noreviq-shadow-{$token}:", $css);
            }
        }

        self::assertStringContainsString('--noreviq-ring-focus:', $this->coreCss);
        self::assertStringContainsString('.fi-btn:focus-visible', $this->coreCss);
    }

    #[Test]
    public function auth_shell_treatment_is_isolated_from_the_core_bundle(): void
    {
        $authCss = $this->read('resources/dist/noreviq-auth.css');

        self::assertStringNotContainsString('.fi-simple-layout', $this->coreCss);
        self::assertStringNotContainsString('.fi-simple-main', $this->coreCss);
        self::assertStringContainsString('.fi-simple-layout', $authCss);
        self::assertStringContainsString('.fi-simple-main', $authCss);
    }

    #[Test]
    public function it_contains_expected_component_and_state_boundaries(): void
    {
        foreach ([
            '.fi-sidebar .fi-sidebar-item-btn .fi-sidebar-item-label',
            ':where(.fi-btn.fi-color-primary:not(.fi-outlined))',
            '.fi-fo-toggle-buttons input:checked + .fi-btn.fi-color-primary',
            '.fi-section:not(.fi-section-not-contained)',
            '.fi-sc-tabs.fi-contained',
            '.fi-toggle > :first-child',
            '.fi-fo-slider .noUi-connects',
            '.fi-sc-wizard-header-step-icon-ctn',
            '.fi-topbar .fi-logo',
            '@media print',
        ] as $selector) {
            self::assertStringContainsString($selector, $this->coreCss);
        }
    }

    #[Test]
    public function it_contains_no_build_time_or_application_specific_css(): void
    {
        $normalized = strtolower($this->allSourceCss);

        foreach (['volt'.'ara', '!important', '@apply', '@import', '@source'] as $forbidden) {
            self::assertStringNotContainsString($forbidden, $normalized);
        }
    }

    #[Test]
    public function it_paints_component_boundaries_without_repainting_inner_layout_wrappers(): void
    {
        self::assertStringContainsString('.fi-fo-builder-block-picker-ctn {', $this->allSourceCss);
        self::assertStringContainsString('.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item.fi-active > .fi-sidebar-item-btn', $this->allSourceCss);
        self::assertStringContainsString('scrollbar-gutter: stable both-edges', $this->allSourceCss);
        self::assertStringContainsString('.fi-sc-wizard-header-step.fi-active .fi-sc-wizard-header-step-icon-ctn .fi-icon', $this->allSourceCss);
        self::assertStringNotContainsString(".fi-fo-builder-block-picker,\n.fi-fo-builder-block-picker-ctn", $this->allSourceCss);
        self::assertStringNotContainsString(".fi-sc-wizard-header-step-btn:hover {\n    background-color:", $this->allSourceCss);
    }

    private function read(string $relativePath): string
    {
        $contents = file_get_contents($this->packagePath($relativePath));

        self::assertIsString($contents);

        return $contents;
    }

    private function packagePath(string $relativePath): string
    {
        return dirname(__DIR__, 2).'/'.$relativePath;
    }
}
