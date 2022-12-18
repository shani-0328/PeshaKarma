<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Customers;

use App\Models\Institutions;
use Session;
class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = Institutions::all();

      
        
       
        return view('admin.institution', compact('institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $departments = Department::pluck('name','id')->all();

       

        return view('admin.institution_add', compact('departments'));
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

            'code'=>'required|unique:institutions,code',
            'name'=>'required|unique:institutions,name'
        ]);

        $institution =  new Institutions();

        $institution->name = $request->input('name');
        $institution->code= $request->input('code');
        $institution->address = $request->input('address');
        $institution->department_id = $request->input('department_id');
        $institution->responsible_person = $request->input('responsible_person');
       
        

        $institution->save();
        Session::flash('Add_institution','The Institution has been successfully Created.');
        return redirect('admin/institutions');
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
        
        $institution = Institutions::findOrFail($id);
        $departments = Department::pluck('name','id')->all();

        return view('admin.institution_edit',compact('institution','departments'));
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
        
        $institution = Institutions::findOrFail($id);

        $institution->name = $request->input('name');
        $institution->code= $request->input('code');
        $institution->department_id = $request->input('department_id');
        $institution->address = $request->input('address');
        $institution->responsible_person = $request->input('responsible_person');

        $institution->update();
        Session::flash('edit_institution','The Institution has been successfully Upadated.');
        return redirect('admin/institutions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $institution = Institutions::findOrFail($id);
        $institution->delete();
        Session::flash('delete_institution','The Institution has been successfully Deleted.');
        return redirect('admin/institutions');
    }

    public function institutionlist($id){

        $department = Department::findOrFail($id);

        $id = $department->id;

        $institutions = Institutions::where('department_id','=', $id)->get();


        return view('admin.institutionlist',compact('institutions', 'department'));
    }

    public function delete($id){

        $institution = Institutions::findOrFail($id);
        $institution->delete();

return redirect('/admin/institutions');
    }


    public function dcustomerlist($id){

        $institution = Institutions::findOrFail($id);

        $customers = Customers::where('institution_id','=', $institution->id)->get();


        return view('admin.customerslist_r_by_institutions',compact('customers','institution'));

    }
}
