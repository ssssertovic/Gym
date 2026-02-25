<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::where('role', 'user')
            ->orderBy('id', 'desc')
            ->with('latestBooking.plan')
            ->get();

        return view('members.index', ['members' => $members]);
    }

    public function file_add(Request $request)
    {
        $id = $request->id;

        $member = User::where('role', 'user')->find($id);

        if ($member === null) {
            return redirect()->route('members');
        }

        return view('members.file_add', ['id' => $id, 'members' => $member]);

    }

    public function process(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $id = $request->id;
        $member = User::where('role', 'user')->find($id);

        if ($member === null) {
            return redirect()->route('members');
        }

        $folder_to_save = 'user_' . $member->id;
        $file = $request->file('file');
        $filename = $member->id . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs((string) $folder_to_save, $filename);

        DB::table('member_files')->insert([
            'member' => $member->id,
            'type' => 0,
            'file' => $path,
        ]);

        return redirect()->route('members')->with('status', 'Fajl je uspješno učitan.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.add');
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
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'height_cm' => $request->height_cm ?? null,
            'weight_kg' => $request->weight_kg ?? null,
            'role' => 'user',
        ]);

        return redirect()->route('members')->with('status', 'Član (user) je uspješno kreiran.');

    }

    public function delete(Request $request){
        $id = $request->id;

        $user = User::find($id);

        if (!$user || $user->role !== 'user') {
            return redirect()->route('members')->with('status', 'Nije dozvoljeno brisanje ovog korisnika.');
        }

        $user->delete();

        return redirect()->route('members')->with('status', 'Član (user) je uspješno obrisan.');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;

        $member = User::where('role', 'user')->find($id);

        if ($member === null) {
            return redirect()->route('members')->with('status', 'Član nije pronađen.');
        }

        $member_files = DB::table('member_files')->where('member', $id)->get();

        return view('members.edit', ['member' => $member, 'member_files' => $member_files]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'height_cm' => 'nullable|integer',
            'weight_kg' => 'nullable|numeric',
            'password' => 'nullable|string|min:8',
        ]);

        $member = User::find($id);

        if ($member === null || $member->role !== 'user') {
            return redirect()->route('members')->with('status', 'Član nije pronađen ili nije dozvoljeno uređivanje.');
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'height_cm' => $request->height_cm ?? null,
            'weight_kg' => $request->weight_kg ?? null,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $member->update($updateData);

        return redirect()->route('members')->with('status', 'Član (user) je uspješno ažuriran.');
    }

    /**
     * Upload photo for a member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $id = $request->id;
        $member = User::where('role', 'user')->find($id);

        if ($member === null) {
            return redirect()->route('members')->with('status', 'Član nije pronađen.');
        }

        // For now, just redirect since User profile photos are handled elsewhere.
        return redirect()->route('members')->with('status', 'Upload profilne slike za korisnike je onemogućen u ovom modulu.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {

    }
}
