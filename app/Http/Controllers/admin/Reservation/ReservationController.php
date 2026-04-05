<?php

namespace App\Http\Controllers\Admin\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index() {
        $user = auth()->user();
        $query = Reservation::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $reservations = $query->latest()->paginate(5); // changed 10 → 5
        return view('Admin.Reservations.table-list', compact('reservations'));
    }

    public function create() {
        return view('Admin.Reservations.table-form');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date'         => 'required|date',
            'time'         => 'required',
            'table_id'     => 'required|integer',
        ]);

        $validated['user_id'] = auth()->id();

        Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', 'Table reserved successfully!');
    }

    public function edit($id) {
        $reservation = Reservation::findOrFail($id);
        return view('Admin.Reservations.table-form', compact('reservation'));
    }

    public function update(Request $request, $id) {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date'         => 'required|date',
            'time'         => 'required',
            'table_id'     => 'required|integer',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')
                         ->with('success', 'Table updated successfully');
    }

    public function destroy($id) {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Table deleted!');
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $user = auth()->user();

        $reservationsQuery = Reservation::query()
            ->where('full_name', 'like', "%{$query}%")
            ->orWhere('phone_number', 'like', "%{$query}%");

        if ($user->role !== 'admin') {
            $reservationsQuery->where('user_id', $user->id);
        }

        $reservations = $reservationsQuery
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('Admin.Reservations.table-list', compact('reservations', 'query'));
    }
}