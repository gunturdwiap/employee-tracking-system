<?php

use App\Enums\VacationRequestStatus;

test('all cases have labels', function () {
    foreach (VacationRequestStatus::cases() as $status) {
        expect($status->label())->toBeString();
    }
});
