<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * List bookings: own for regular user, all for admin.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $bookings = DB::table('bookings')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('plans', 'bookings.plan_id', '=', 'plans.id')
                ->join('trainers', 'bookings.trainer_id', '=', 'trainers.id')
                ->select(
                    'bookings.*',
                    'users.name as user_name',
                    'plans.name as plan_name',
                    'trainers.name as trainer_name',
                    'trainers.lastname as trainer_lastname'
                )
                ->orderByDesc('bookings.scheduled_at')
                ->get();
        } else {
            $bookings = DB::table('bookings')
                ->join('plans', 'bookings.plan_id', '=', 'plans.id')
                ->join('trainers', 'bookings.trainer_id', '=', 'trainers.id')
                ->select(
                    'bookings.*',
                    'plans.name as plan_name',
                    'trainers.name as trainer_name',
                    'trainers.lastname as trainer_lastname'
                )
                ->where('bookings.user_id', $user->id)
                ->orderByDesc('bookings.scheduled_at')
                ->get();
        }

        return view('bookings.index', ['bookings' => $bookings]);
    }

    /**
     * Show form to create a booking (plan + trainer + date/time).
     */
    public function create()
    {
        $plans = DB::table('plans')->orderBy('name')->get();
        $trainers = DB::table('trainers')->orderBy('name')->get();

        return view('bookings.create', [
            'plans' => $plans,
            'trainers' => $trainers,
        ]);
    }

    /**
     * Store a new booking for the authenticated user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|integer|exists:plans,id',
            'trainer_id' => 'required|integer|exists:trainers,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'plan_id' => $request->plan_id,
            'trainer_id' => $request->trainer_id,
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
        ]);

        return redirect()->route('bookings.index')->with('status', 'Rezervacija je uspješno kreirana.');
    }
}
