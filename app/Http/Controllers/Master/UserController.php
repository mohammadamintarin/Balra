<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $count = count($users);
        $title = "کاربران";
        return view('master.user.index' , compact(['users' , 'count' ,  'title']));
    }

    public function create()
    {
        $title = "افزودن کاربر";
        return view('master.user.create' , compact('title'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            User::create([
                'name' => $request->name,
                'family' => $request->family,
                'mobile' => $request->mobile,
                'otp' =>1234,
                'remember_token' =>'4lAprYWqetwAt7eQQWU4I2OT10lRKY8FDN3WsxCES3Bu6PX3S097dYuyeRez/zKZkwzDbxTUAO' . rand(1,999),
                'token' =>'$2y$12$ZunXQKZ2kKTx7hCMMTAgqO6OObuWUjVF8yXlm3J/zKZkwzDbxTUAO' . rand(1,999)
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'کاربر ایجاد نشد!');
        }
        return redirect()->route('master.user.index')->with('message', 'کاربر' . ' ' . $request->name . ' ' . 'ایجاد شد!');
    }
    public function show(User $user)
    {
        $title = $user->name ." ". $user->family;
        $orderItems = $user->orders()->with('orderItems')->get();
        return view('master.user.detail' , compact('user' , 'title' , 'orderItems'));
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $title = "سطح  دسترسی";
        return view('master.user.edit' , compact('user' , 'title' , 'roles' ));
    }
    public function update(Request $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
            ]);
            $user->syncRoles($request->role);
            $permissions = $request->except('_token', 'name','family','avatar' , 'mobile','_method' , 'role');
            $user->syncPermissions($permissions);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return redirect()->back();
        }
        return redirect()->route('master.user.index')->with('info', 'کاربر' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    public function address(User $user)
    {
        $title = "افزودن آدرس برای" . " " . $user->name ." ". $user->family;
        $addresses = UserAddress::where('user_id', $user->id)->get();
        $provinces = Province::all();
        return view('master.user.address' , compact(['user' , 'title' , 'addresses' , 'provinces']));
    }

}
