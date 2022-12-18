<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserStoreRequest;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        return view('admin.users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $roles = Role::pluck('name','id')->all();
      
        return view('admin.user_add',compact('roles'));
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

                'phone_number'=>'required|unique:users,phone_number|min:10|max:10',
               
                'password'=>'required|min:6'
            ]);
        
            $user =  new User();

            $user->name = $request->input('name');
            $user->email= $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone_number = $request->input('phone_number');
            $user->role_id = $request->input('role_id');

           

            $user->save();

            Session::flash('Add_user','The User has been successfully Created.');
        
            return redirect('admin/users');
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
        

        $user = User::findOrFail($id);
        $roles = Role::pluck('name','id')->all();

        return view('admin.user_edit',compact('user','roles'));
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


        
        $user = User::findOrFail($id);

        $request->validate([

            'phone_number'=>'required|min:10|max:10',
            'email'=>'required',
            'password'=>'required|min:6'
        ]);

        $user->name = $request->input('name');
        $user->email= $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone_number = $request->input('phone_number');
        $user->role_id = $request->input('role_id');

        $user->update();
        Session::flash('edit_user','The User has been successfully Updated.');   
        return redirect('admin/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = User::findOrFail($id);
         
        $user->delete();
        Session::flash('delete_user','The User has been successfully Deleted.');
        return redirect('admin/users');

        // echo "deleted";
    }


    public function delete($id){

        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users');
    }

    public function profileupdate(Request $request, $id){


        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');

        $user->update();

        return redirect()->back();

    }

    public function passwordupdate(Request $request, $id){


        $request->validate([

            'old_password'=>'required|min:6|max:100',
            'password'=>'required|min:6|max:100',
            'c_password'=>'required|same:password'
        ]);

        $user = User::findOrFail($id);

        $current_user = auth()->user();

        // dd($current_user->password);

        if(Hash::check($request->old_password, $current_user->password)){
            
          
            $current_user->update([
                'password'=>bcrypt($request->password)
            ]);

            return redirect()->back();

        }else{

            return redirect()->back()->with('error','old password does not matched.');
        }

    }
}
