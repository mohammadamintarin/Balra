<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $count = count($permissions);
        $title="سطح دسترسی";
        return view('master.permission.index' , compact('permissions' , 'count' , 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.permission.create');
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
            'name' => 'required',
            'display_name' => 'required',
        ]);
        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => "web"
        ]);
        return redirect()->route('master.permission.index')->with('message', ' ' . ' ' . $request->display_name . ' ' . 'ایجاد شد!');
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
    public function edit(Permission $permission)
    {
        $title="سطح دسترسی";
        return view('master.permission.edit' , compact('permission' , 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
        ]);
        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => "web"
        ]);
        return redirect()->route('master.permission.index')->with('info', 'دسترسی' . ' ' . $request->display_name . ' ' . 'ویرایش  شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
