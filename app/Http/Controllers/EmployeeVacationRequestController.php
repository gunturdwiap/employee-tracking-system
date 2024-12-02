<?php

namespace App\Http\Controllers;

use App\Models\VacationRequest;
use Illuminate\Http\Request;
use App\Enums\VacationRequestStatus;

class EmployeeVacationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vacationRequests = VacationRequest::query()
            ->where('user_id', auth()->id())
            ->paginate(15);

        return $vacationRequests;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.vacation-request');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'start' => ['required', 'date', 'after:today', 'before_or_equal:end'],
            'end' => ['required', 'date', 'after:today', 'after_or_equal:start'],
            'reason' => ['nullable', 'max:255']
        ]);

        // Check if the new vacation request overlaps with any existing approved vacation
        $existingRequest = VacationRequest::where('user_id', $request->user()->id)
            ->where('status', VacationRequestStatus::APPROVED)
            ->where(function ($query) use ($request) {
                $query->whereDate('start', '<=', $request->end)   // Existing vacation starts before or on the new request's end date
                    ->whereDate('end', '>=', $request->start);  // Existing vacation ends after or on the new request's start date
            })
            ->exists();


        if ($existingRequest) {
            return back()->with('danger', 'You already have an approved vacation request for this day.');
        }

        $request->user()->vacationRequests()->create($attributes);

        return to_route('employee.vacation')->with('success', 'Vacation request created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //check if vacation request exist for the current user

        // return vacation request for the current user
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //check if vacation request exist for the current user

        // update

        // return vacation request for the current user
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //check if vacation request exist for the current user

        // check vacation request status, proceed if not yet approved

        // delete

        // return
    }
}
