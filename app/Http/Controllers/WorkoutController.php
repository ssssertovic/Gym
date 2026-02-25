<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use DB;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        $from = now()->subDays(30)->startOfDay();
        $to = now()->endOfDay();

        $workouts = DB::table('workouts')
            ->join('members', 'workouts.member', '=', 'members.id')
            ->join('trainers', 'workouts.trainer', '=', 'trainers.id')
            ->select('workouts.*', 'members.name as member_name', 'trainers.name as trainer_name', 'trainers.lastname as trainer_lastname')
            ->orderByDesc('workouts.date')
            ->limit(50)
            ->get();

        $most_common_members = DB::table('members')
            ->select('members.*', DB::raw('count(*) as brojac'))
            ->groupBy('members.id')
            ->join('workouts', 'members.id', '=', 'workouts.member')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        $most_common_plans = DB::table('members')
            ->select('plans.*', DB::raw('count(*) as brojac'))
            ->groupBy('plans.id')
            ->join('workouts', 'members.id', '=', 'workouts.member')
            ->join('plans', 'members.plan', '=', 'plans.id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        $number_of_workouts = DB::table('workouts')
            ->whereBetween('date', [$from, $to])
            ->count();

        $top_trainers_this_month = DB::table('trainers')
            ->select('trainers.name as trainer_name', 'trainers.lastname as trainer_lastname', DB::raw('count(*) as brojac'))
            ->groupBy('trainers.id')
            ->join('workouts', 'trainers.id', '=', 'workouts.trainer')
            ->whereBetween('date', [$from, $to])
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('workouts.index', [
            'workouts' => $workouts,
            'most_common_members' => $most_common_members,
            'most_common_plans' => $most_common_plans,
            'number_of_workouts' => $number_of_workouts,
            'top_trainers_this_month' => $top_trainers_this_month,
        ]);
    }

    public function create()
    {
        $members = DB::table('members')->orderBy('name')->get();
        $trainers = DB::table('trainers')->orderBy('name')->get();
        return view('workouts.add', ['members' => $members, 'trainers' => $trainers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member' => 'required|integer',
            'trainer' => 'required|integer',
            'date' => 'required|date',
            'grade' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        $code = (DB::table('workouts')->max('code') ?? 0) + 1;

        DB::table('workouts')->insert([
            'code' => $code,
            'date' => $request->date,
            'grade' => $request->grade,
            'description' => $request->description ?? null,
            'trainer' => $request->trainer,
            'member' => $request->member,
        ]);

        return redirect()->route('workouts')->with('status', 'Workout created successfully.');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Workout::destroy($id);
        return redirect()->route('workouts')->with('status', 'Workout deleted successfully.');
    }
}
