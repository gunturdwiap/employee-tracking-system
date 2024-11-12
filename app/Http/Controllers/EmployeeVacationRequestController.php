<?php

namespace App\Http\Controllers;

use App\Models\VacationRequest;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeVacationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'start' => ['required', 'date', 'after:today', 'before:end'],
            'end' => ['required', 'date', 'after:today', 'after:start'],
            'reason' => ['nullable', 'max:255']
        ]);

        $request->user()->vacationRequests()->create($attributes);

        return to_route('employee.vacation')->with('success', 'Vacation request created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
