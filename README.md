# Noreviq Filament Theme

<p align="center">
    <img src="docs/images/noreviq-dashboard-dark.png" alt="Noreviq dashboard in dark mode" width="100%">
</p>

<p align="center"><sub>Noreviq dashboard · Dark mode</sub></p>

Noreviq is a teal and graphite theme plugin for Filament panels. It ships as
ready-to-use CSS with no frontend build step in the consuming application.

## Preview

<p align="center">
    <img src="docs/images/noreviq-login-dark.png" alt="Noreviq sign-in page in dark mode" width="100%">
    <br>
    <sub>Authentication · Dark mode</sub>
</p>

<p align="center">
    <img src="docs/images/noreviq-components-dark.png" alt="Noreviq component lab in dark mode" width="100%">
    <br>
    <sub>Native Filament components · Dark mode</sub>
</p>

### Light mode

<p align="center">
    <img src="docs/images/noreviq-details-light.png" alt="Noreviq schema components in light mode" width="100%">
    <br>
    <sub>Native Filament components · Light mode</sub>
</p>

## Compatibility

| Filament | PHP |
| --- | --- |
| 4.x | 8.2+ |
| 5.x | 8.2+ |

## Installation

### 1. Install the package

```bash
composer require noreviq/filament-theme
```

### 2. Register the plugin

Register the plugin on each panel that should use Noreviq:

```php
use Filament\Panel;
use Noreviq\FilamentTheme\NoreviqThemePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // Keep your normal panel configuration here.
        ->plugin(NoreviqThemePlugin::make());
}
```

### 3. Publish the assets

> [!IMPORTANT]
> Register the plugin before running the asset command. Filament discovers
> Noreviq's panel assets from the registered plugin, so running the command
> before registration will not publish the theme styles.

After registering the plugin and choosing any presets, publish the theme assets:

```bash
php artisan filament:assets
```

No configuration file or frontend build is required.

## Options

Noreviq exposes three typed visual options:

```php
use Noreviq\FilamentTheme\Enums\AuthStyle;
use Noreviq\FilamentTheme\Enums\CornerStyle;
use Noreviq\FilamentTheme\Enums\ShadowStyle;

NoreviqThemePlugin::make()
    ->corners(CornerStyle::Sharp)
    ->shadows(ShadowStyle::Balanced)
    ->authStyle(AuthStyle::Noreviq);
```

| Option | Values | Default |
| --- | --- | --- |
| Corners | `Sharp`, `Subtle`, `Native` | `Sharp` |
| Shadows | `Flat`, `Balanced`, `Elevated` | `Balanced` |
| Auth | `Noreviq`, `Native` | `Noreviq` |

Run `php artisan filament:assets` again after changing a preset or upgrading the
package.

The palette is part of the theme and is intentionally fixed. Noreviq does not
change panel navigation, dimensions, content width, branding, font, routes,
authentication, authorization, responsiveness, or component behavior.

## Troubleshooting

If the default Filament theme still appears:

1. Confirm that the plugin is registered on the active panel.
2. Run `php artisan filament:assets` after registration.
3. Hard refresh the browser.

## License

MIT. Created by Yousef Al-Jallad
([eng.yousef.aljallad@gmail.com](mailto:eng.yousef.aljallad@gmail.com)).
