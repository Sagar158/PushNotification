<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Users';
    public function index()
    {
        $this->authorize('viewAny',User::class);
        $title = $this->title;
        return view('users.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',User::class);
        $title = $this->title;
        $user = new User;
        return view('users.edit',compact('title','user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',User::class);
        $validatedData = $request->validate([
            'email' => 'required|string|max:255|email|unique:users,email',
            'user_type_id' => 'required',
            'name' => 'required|string',
            'password' => 'required|string|min:6|max:255',
        ]);

        $user = new User;
        $user->email = $validatedData['email'];
        $user->user_type_id = $validatedData['user_type_id'];
        $user->name = $validatedData['name'];
        $user->save();

            $user->forceFill([
                'password' => Hash::make($validatedData['password']),
                'remember_token' => Str::random(60),
            ])->save();

        return redirect()->route('users.index')->with('success','User created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $userId)
    {
        $this->authorize('update',User::class);
        $title = $this->title;
        $user = User::findOrFail($userId);
        return view('users.edit',compact('title','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $this->authorize('update',User::class);
        $validatedData = $request->validate([
            'email' => 'required|string|unique:users,email,' . $userId,
            'user_type_id' => 'required',
            'name' => 'required|string',
        ]);

        $user = User::findOrFail($userId);
        $user->email = $validatedData['email'];
        $user->user_type_id = $validatedData['user_type_id'];
        $user->name = $validatedData['name'];

        if(!empty($request->password))
        {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();
        }
        $user->save();



        return redirect()->route('users.index')->with('success','User updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $this->authorize('delete',User::class);
        $record = User::destroy($userId);
        return response()->json(['success' => $record]);

    }

    public function getUserData()
    {
        $this->authorize('viewAny',User::class);
        $query = User::with(['usertype']);

        return DataTables::of($query)
            ->addColumn('usertype',function($user){
                return $user->usertype->name;
            })
            ->addColumn('status', function($user){
                if($user->isOnline()){
                    return '<span class="badge badge-success">Online</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Offline</span>';
                }
            })
            ->addColumn('action', function ($user) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('users.edit', $user->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('users.destroy', $user->id).'" data-id="'.$user->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action','usertype','status'])
            ->make(true);
    }
    public function changeStatus(Request $request, $userId)
    {
        $this->authorize('update',User::class);
        $user = User::findOrFail($userId);

        if($user->status == 'active')
        {
            $user->status = 'inactive';
        }
        else
        {
            $user->status = 'active';
        }
        $user->save();

        return response()->json(['success' => 1]);
    }

}
