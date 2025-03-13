<?php

use App\Enums\UserRole;

test('all cases have labels', function () {
    foreach (UserRole::cases() as $status) {
        expect($status->label())->toBeString();
    }
});
