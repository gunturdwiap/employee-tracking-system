<?php

use App\Enums\AttendanceStatus;

test('all cases have labels', function () {
    foreach (AttendanceStatus::cases() as $status) {
        expect($status->label())->toBeString();
    }
});
