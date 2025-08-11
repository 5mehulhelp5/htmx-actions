<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums\Trait;

trait FromName
{
    public static function tryFromName(string $name): ?self
    {
        static $map = null;

        if ($map === null) {
            $map = [];
            foreach (self::cases() as $case) {
                $map[$case->name] = $case;
            }
        }

        return $map[$name] ?? null;
    }
}
