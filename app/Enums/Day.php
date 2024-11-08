<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Day: string
{
    case SUNDAY = 'sunday';
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';

    public static function options(): array
    {
        $cases = self::cases();
        $options = [];
        foreach ($cases as $case) {
            $label = $case->name;
            if (Str::contains($label, '_')) {
                $label = Str::replace('_', ' ', $label);
            }
            $options[] = [
                'value' => $case->value,
                'label' => Str::title($label)
            ];
        }
        return $options;
    }

    public static function toArray(): array
    {
        return [
            self::SUNDAY->value => 'SUNDAY',
            self::MONDAY->value => 'MONDAY',
            self::TUESDAY->value => 'TUESDAY',
            self::WEDNESDAY->value => 'WEDNESDAY',
            self::THURSDAY->value => 'THURSDAY',
            self::FRIDAY->value => 'FRIDAY',
            self::SATURDAY->value => 'SATURDAY',
        ];
    }
}
