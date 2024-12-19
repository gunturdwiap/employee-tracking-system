<?php

namespace App\Http\Controllers;

use App\Models\VacationRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class VacationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vacationRequests = VacationRequest::with(['user']);

        $request->validate([
            'status' => ['nullable', 'array'],
            's' => ['nullable', 'string']
        ]);

        if ($request->filled('status')) {
            $vacationRequests->whereIn('status', $request->status);
        }

        if ($request->filled('s')) {
            $vacationRequests->whereHas('user', function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->s . '%');
            });
        }

        return view('vacation-request.index', [
            'vacationRequests' => $vacationRequests->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VacationRequest $vacationRequest)
    {
        return $vacationRequest;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VacationRequest $vacationRequest)
    {
        return $vacationRequest;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VacationRequest $vacationRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VacationRequest $vacationRequest)
    {
        $vacationRequest->delete();

        return back()->with('success', 'Vacation request deleted');
    }
}
