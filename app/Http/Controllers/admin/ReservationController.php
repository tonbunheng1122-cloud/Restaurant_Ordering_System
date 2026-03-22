<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    
    public function index() {
        $reservations = Reservation::latest()->paginate(10);
        return view('admin.itemMenu.alltable', compact('reservations'));
    }


    public function create() {
        return view('admin.itemMenu.addtable');
    }


    public function store(Request $request) {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'table_id' => 'required|integer',
        ]);

        Reservation::create($validated);

        return redirect()->route('alltable.index')->with('success', 'Table reserved successfully!');
    }
    
    public function edit($id) {
        $reservation = Reservation::findOrFail($id);
        return view('admin.itemMenu.addtable', compact('reservation'));
    }
    
    public function update(Request $request, $id) {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'table_id' => 'required|integer',
        ]);
        $reservation->update($validated);
        return redirect()->route('alltable.index')
                         ->with('success', 'Table updated successfully');
    }
    
    public function destroy($id) {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('alltable.index')->with('success', 'Table deleted!');
    }
    
    public function search(Request $request){
        $query = $request->input('query');
        $reservations = Reservation::query()
            ->where('full_name', 'like', "%{$query}%")
            ->orWhere('phone_number', 'like', "%{$query}%")
            ->latest()
            ->paginate(10)
            ->withQueryString(); 

        return view('admin.itemMenu.alltable', compact('reservations', 'query'));
    }
}   