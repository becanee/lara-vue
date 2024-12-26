<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends BaseController
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_user_management|update_user_management|delete_user_management', ['only' => ['index','show']]);
        $this->middleware('permission:update_user_management', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_user_management', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userDatas = User::query();
        
        // dd(Auth::user());

        return Inertia::render('Management/Users/index', [
            'userDatas' => $userDatas->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         //get user by ID
         $newFormData = User::findOrFail($request->id);
         $newFormData->update([
            'name'         => $request->name,
            'email'   => $request->email,
            'is_active'         => $request->is_active
        ]);
        
        return redirect()->route('manage.user')->with('success', 'User updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
