<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class NoreviqThemeServiceProvider extends PackageServiceProvider
{
    public static string $name = 'noreviq-filament-theme';

    public function configurePackage(Package $package): void
    {
        $package->name(self::$name);
    }
}
