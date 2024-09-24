<?php

namespace App\Http\Controllers;

use App\CPU\FileManager;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private const FOLDER_PATH_LOCAL = 'images/users';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('name', 'like', '%'.$search.'%')->paginate(5);
        return view('users.index', compact('users','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $request->all();
        $user['password'] = bcrypt($request->password);
        //upload image
        $fileImage  = $request->file('avatar');
        if ($fileImage) {
            $url = FileManager::upload($fileImage, $this::FOLDER_PATH_LOCAL);
            if ($url == 'Error33') {
                return back()->with('error', 'Error url!');
            }else {
                $user['avatar'] = $url;
            }
        }
        User::create($user);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $user['password'] = bcrypt($request->password);
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['role'] = $request->role;
        //upload image
        $fileImage  = $request->file('avatar');
        if ($fileImage) {
            FileManager::delete($user->avatar, 'key_image');
            $url = FileManager::upload($fileImage, $this::FOLDER_PATH_LOCAL);
            if ($url == 'Error33') {
                return back()->with('error', 'Error url!');
            }
            $user['avatar'] = $url;
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        FileManager::delete($user->avatar, 'key_image');
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
