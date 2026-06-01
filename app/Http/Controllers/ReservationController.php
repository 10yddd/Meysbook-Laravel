<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        $reservations = Reservation::where('user_id', session('user')->id)->get();
        return view('reservations', compact('reservations'));
    }

    public function store(Request $request)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        Reservation::create([
            'user_id'          => session('user')->id,
            'name'             => $request->name,
            'contact'          => $request->contact,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guests'           => $request->guests,
            'status'           => $request->status,
            'notes'            => $request->notes,
        ]);
        return back()->with('success', 'Reservation added successfully');
    }

    public function edit($id)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        $editReservation = Reservation::findOrFail($id);
        $reservations    = Reservation::where('user_id', session('user')->id)->get();
        return view('reservations', compact('reservations', 'editReservation'));
    }

    public function update(Request $request, $id)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        $reservation = Reservation::findOrFail($id);
        $reservation->name             = $request->name;
        $reservation->contact          = $request->contact;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->guests           = $request->guests;
        $reservation->status           = $request->status;
        $reservation->notes            = $request->notes;
        $reservation->save();
        return redirect('/reservations')->with('success', 'Reservation updated successfully');
    }

    public function destroy($id)
    {
        if (!session('user')) {
            return redirect('/login')->with('error', 'Please login first');
        }
        Reservation::findOrFail($id)->delete();
        return back()->with('success', 'Reservation deleted successfully');
    }
}