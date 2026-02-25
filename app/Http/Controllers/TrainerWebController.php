<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerWebController extends Controller
{
    public function index()
    {
        $trainers = DB::table('trainers')->orderBy('name')->get();
        return view('trainers.index', ['trainers' => $trainers]);
    }

    public function create()
    {
        return view('trainers.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        DB::table('trainers')->insert([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'level' => $request->level ?? 0,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('trainers')->with('status', 'Trainer created successfully.');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $trainers = DB::table('trainers')->where('id', $id)->get();
        return view('trainers.edit', ['trainers' => $trainers]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        DB::table('trainers')->where('id', $id)->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'level' => $request->level ?? 0,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('trainers')->with('status', 'Trainer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        Trainer::destroy($id);
        return redirect()->route('trainers')->with('status', 'Trainer deleted successfully.');
    }

    /**
     * Display the specified trainer (read-only for users).
     */
    public function show($id)
    {
        $trainer = DB::table('trainers')->where('id', $id)->first();
        if (!$trainer) {
            return redirect()->route('trainers')->with('status', 'Trener nije pronađen.');
        }
        return view('trainers.show', ['trainer' => $trainer]);
    }
}
