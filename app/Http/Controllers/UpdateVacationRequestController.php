<?php

namespace App\Http\Controllers;

use App\Enums\VacationRequestStatus;
use Illuminate\Http\Request;
use App\Models\VacationRequest;
use Illuminate\Validation\Rule;

class UpdateVacationRequestController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function __invoke(Request $request, VacationRequest $vacationRequest)
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

        return back()->with('success', 'Vacation request status updated');
    }
}
