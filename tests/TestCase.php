<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Tests;

use Filament\FilamentServiceProvider;
use Noreviq\FilamentTheme\NoreviqThemeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /** @return array<class-string> */
    protected function getPackageProviders($app): array
    {
        return [
            FilamentServiceProvider::class,
            NoreviqThemeServiceProvider::class,
        ];
    }
}
