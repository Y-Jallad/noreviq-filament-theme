<?php

declare(strict_types=1);

namespace Noreviq\FilamentTheme\Support;

final class Palette
{
    /**
     * @return array<string, array<int, string>>
     */
    public static function all(): array
    {
        return [
            'primary' => self::primary(),
            'gray' => self::gray(),
            'danger' => self::danger(),
            'info' => self::info(),
            'success' => self::success(),
            'warning' => self::warning(),
        ];
    }

    /** @return array<int, string> */
    public static function primary(): array
    {
        return [
            50 => '#f0fdfa',
            100 => '#ccfbf1',
            200 => '#99f6e4',
            300 => '#5eead4',
            400 => '#2dd4bf',
            500 => '#14b8a6',
            600 => '#0f766e',
            700 => '#115e59',
            800 => '#134e4a',
            900 => '#0b3b38',
            950 => '#042f2e',
        ];
    }

    /** @return array<int, string> */
    public static function gray(): array
    {
        return [
            50 => '#f7f8f8',
            100 => '#eff1f1',
            200 => '#dde1e1',
            300 => '#c8cece',
            400 => '#98a1a1',
            500 => '#6c7676',
            600 => '#4e5858',
            700 => '#374040',
            800 => '#252c2c',
            900 => '#171c1c',
            950 => '#0d1111',
        ];
    }

    /** @return array<int, string> */
    public static function danger(): array
    {
        return [
            50 => '#fff1f2',
            100 => '#ffe4e6',
            200 => '#fecdd3',
            300 => '#fda4af',
            400 => '#fb7185',
            500 => '#f43f5e',
            600 => '#e11d48',
            700 => '#be123c',
            800 => '#9f1239',
            900 => '#881337',
            950 => '#4c0519',
        ];
    }

    /** @return array<int, string> */
    public static function info(): array
    {
        return [
            50 => '#f0f9ff',
            100 => '#e0f2fe',
            200 => '#bae6fd',
            300 => '#7dd3fc',
            400 => '#38bdf8',
            500 => '#0ea5e9',
            600 => '#0284c7',
            700 => '#0369a1',
            800 => '#075985',
            900 => '#0c4a6e',
            950 => '#082f49',
        ];
    }

    /** @return array<int, string> */
    public static function success(): array
    {
        return [
            50 => '#f0fdf4',
            100 => '#dcfce7',
            200 => '#bbf7d0',
            300 => '#86efac',
            400 => '#4ade80',
            500 => '#22c55e',
            600 => '#16a34a',
            700 => '#15803d',
            800 => '#166534',
            900 => '#14532d',
            950 => '#052e16',
        ];
    }

    /** @return array<int, string> */
    public static function warning(): array
    {
        return [
            50 => '#fffbeb',
            100 => '#fef3c7',
            200 => '#fde68a',
            300 => '#fcd34d',
            400 => '#fbbf24',
            500 => '#f59e0b',
            600 => '#d97706',
            700 => '#b45309',
            800 => '#92400e',
            900 => '#78350f',
            950 => '#451a03',
        ];
    }
}
