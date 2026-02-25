<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Trainer::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $trainer = Trainer::create($request->all());
        return response()->json($trainer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trainer = Trainer::find($id);

        if ($trainer === null) {
            return response()->json(['message' => 'Trainer not found'], 404);
        }

        return response()->json($trainer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'level' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $trainer = Trainer::find($id);

        if ($trainer === null) {
            return response()->json(['message' => 'Trainer not found'], 404);
        }

        $trainer->update($request->all());
        return response()->json($trainer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Trainer::destroy($id);

        if ($deleted === 0) {
            return response()->json(['message' => 'Trainer not found'], 404);
        }

        return response()->json(null, 204);
    }
}
