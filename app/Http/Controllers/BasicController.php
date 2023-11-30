<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\Role;
use App\Models\User as ModelsUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('basic.list', [
            'title' => 'Basic CRUD',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic.create', [
            'title' => 'New User',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = ModelsUser::create([
                'identity_number' => $request->identity_number,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $dosenRole = Role::where('name', 'dosen')->first();
            $mahasisiswaRole = Role::where('name', 'mahasiswa')->first();
            $sadminRole = Role::where('name', 'sadmin')->first();

            switch ($request->type) {
                case 'lecturer':
                    $user->syncRolesWithoutDetaching([$dosenRole]);
                    break;
                case 'student':
                    $user->syncRolesWithoutDetaching([$mahasisiswaRole]);
                    break;
                case 'admin':
                    $user->syncRolesWithoutDetaching([$sadminRole]);
                    break;
            }
            DB::commit();
            return redirect()->route('basic.index')->with('message', 'User added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->route('basic.index')->with('message', 'User added failed!');
        }
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
    public function edit(User $basic)
    {
        return view('basic.edit', [
            'title' => 'Edit User',
            'user' => $basic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $basic)
    {
        if ($request->filled('password')) {
            $basic->password = Hash::make($request->password);
        }
        $basic->name = $request->name;
        $basic->last_name = $request->last_name;
        $basic->email = $request->email;
        $basic->save();

        return redirect()->route('basic.index')->with('message', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $basic)
    {
        if (Auth::id() == $basic->getKey()) {
            return redirect()->route('basic.index')->with('warning', 'Can not delete yourself!');
        }

        $basic->delete();

        return redirect()->route('basic.index')->with('message', 'User deleted successfully!');
    }
}
