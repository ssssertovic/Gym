<?php

namespace App\Http\Controllers;
use DB;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = DB::table('plans')
            ->orderBy('price')
            ->get();

        return view('plans.index', ['plans' => $plans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        DB::table('plans')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days ?? null,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('plans')->with('status', 'Plan created successfully.');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $plans = DB::table('plans')->where('id', $id)->get();
        return view('plans.edit', ['plans' => $plans]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        DB::table('plans')->where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days ?? null,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('plans')->with('status', 'Plan updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        DB::table('plans')->where('id', $id)->delete();
        return redirect()->route('plans')->with('status', 'Plan deleted successfully.');
    }

    /**
     * Display the specified plan (read-only for users).
     */
    public function show($id)
    {
        $plan = DB::table('plans')->where('id', $id)->first();
        if (!$plan) {
            return redirect()->route('plans')->with('status', 'Plan nije pronađen.');
        }
        return view('plans.show', ['plan' => $plan]);
    }

    public function destroy(Plan $plan)
    {
        //
    }
}
