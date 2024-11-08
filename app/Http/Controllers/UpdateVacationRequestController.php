<?php

namespace App\Http\Controllers;

use App\Enums\Enums\VacationRequestStatus;
use Illuminate\Http\Request;
use App\Models\VacationRequest;
use Illuminate\Validation\Rule;

class UpdateVacationRequestController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VacationRequest $vacationRequest)
    {
        $request->validate([
            'status' => [
                'required',
                Rule::enum(VacationRequestStatus::class)
                    ->except(VacationRequestStatus::PENDING)
            ]
        ]);

        $vacationRequest->update([
            'status' => $request->status
        ]);

        return to_route('vacation-requests.index')->with('success', 'Vacation request status updated');
    }
}
