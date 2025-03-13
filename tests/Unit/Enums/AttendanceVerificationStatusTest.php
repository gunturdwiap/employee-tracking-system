<?php

use App\Enums\AttendanceVerificationStatus;

test('all cases have labels', function () {
    foreach (AttendanceVerificationStatus::cases() as $status) {
        expect($status->label())->toBeString();
    }
});
