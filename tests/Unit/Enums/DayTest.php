<?php

use App\Enums\Day;

test('all cases have labels', function () {
    foreach (Day::cases() as $status) {
        expect($status->label())->toBeString();
    }
});

test('all cases values are iso weekdays', function () {
    expect(Day::MONDAY->value)->toBe(1);
    expect(Day::TUESDAY->value)->toBe(2);
    expect(Day::WEDNESDAY->value)->toBe(3);
    expect(Day::THURSDAY->value)->toBe(4);
    expect(Day::FRIDAY->value)->toBe(5);
    expect(Day::SATURDAY->value)->toBe(6);
    expect(Day::SUNDAY->value)->toBe(7);
});

