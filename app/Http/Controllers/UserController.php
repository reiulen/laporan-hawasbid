<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $user = User::select('id', 'name', 'profile_photo_path as image', 'email', 'jabatan')
                            ->where('name', 'like', '%'.$request->keyword.'%')
                            ->orwhere('email', 'like', '%'.$request->keyword.'%')
                            ->get();
        return $user->toJson();
    }


    public function index()
    {
        $data = User::where('id', '!=', Auth::user()->id)
                     ->latest()
                     ->get();
        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 3)
            return abort(404);
        return view('user.create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == 3)
            return abort(404);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'jabatan' => 'required',
            'role' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if($request->role == 3)
            $request->validate([
                'jabatan' => 'required',
            ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        User::create($input);

        return redirect(route('user.index'))
                    ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == 3)
            return abort(404);
        $data = User::findOrFail($id);
        return view('user.create-update', compact('data'));
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
        if(Auth::user()->role == 3)
            return abort(404);
        $data = User::findOrFail($id);
        if($request->role == 3)
            $request->validate([
                'jabatan' => 'required',
            ]);
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        if($request->password || $request->password_confirmation)
            $request->validate([
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ]);

        $input = $request->all();
        if($request->password)
            $input['password'] = bcrypt($input['password']);
        else
            $input['password'] = $data->password;
        $data->update($input);

        return redirect(route('user.index'))
                    ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role != 1)
            return abort(404);
        $data = User::findOrFail($id);
        if($data->profile_photo_path)
            File::delete("/uploads/images/$data->profile_photo_path");
        $data->delete();

        return redirect(route('user.index'))
                    ->with('success', 'Data berhasil dihapus');
    }
}
