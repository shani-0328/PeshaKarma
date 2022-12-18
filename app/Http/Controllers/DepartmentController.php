<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Session;

use DB;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $departments = Department::all();

    //     $departments = DB::table('departments')
    //     ->join('institutions', 'institutions.department_id', '=', 'departments.id')
    //     ->select(
    //         'departments.id AS ID',
    //         'departments.name AS d_name',
    //         'departments.code AS d_code',
    //         'departments.total_loan_amount AS d_tot',
    //         'departments.percentage AS d_percentage',
    //         DB::raw("count(institutions.department_id) AS total_institutions"))
    // ->groupBy('departments.id')
    // ->groupBy('departments.name')
    // ->groupBy('departments.percentage')
    // ->groupBy('departments.total_loan_amount')
    // ->groupBy('departments.code')
    // ->get();

        return view('admin.department', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        return view('admin.department_add');
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

            'code'=>'required|unique:departments,code',
            'name'=>'required|unique:departments,name',
            
        ]);

        $department =  new Department();

        $department->name = $request->input('name');
        $department->code= $request->input('code');
        

       

        $department->save();
        Session::flash('Add_department','The Department has been successfully Created.');
        return redirect('admin/departments');
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
        //

        $department = Department::findOrFail($id);


        return view('admin.department_edit',compact('department'));
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
        //

        $department = Department::findOrFail($id);

        $department->name = $request->input('name');
        $department->code= $request->input('code');
    

        $department->update();
        Session::flash('edit_department','The Department has been successfully Updated.');
        return redirect('admin/departments');

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

        $department = Department::findOrFail($id); 
        $department->delete();
        Session::flash('delete_department','The Department has been successfully Deleted.');
        return redirect('admin/departments');
    }


    public function departmentlist(){


        $departments = Department::all();

        $departmentss = DB::table('departments')
        ->leftjoin('institutions', 'institutions.department_id', '=', 'departments.id')
        ->select(
            'departments.id AS ID',
            'departments.name AS d_name',
            'departments.percentage AS d_percentage',
            DB::raw("count(institutions.department_id) AS total_institutions"))
    ->groupBy('departments.id')
    ->groupBy('departments.name')
    ->groupBy('departments.percentage')
    ->get();



        return view('admin.departmentlist', compact('departments','departmentss'));
    }

    public function departmentlisttable(){

        $departments = Department::all();


        $departmentss = DB::table('departments')
        ->leftjoin('institutions', 'institutions.department_id', '=', 'departments.id')
        ->select(
            'departments.id AS ID',
            'departments.name AS d_name',
            'departments.code AS d_code',
            'departments.total_loan_amount AS d_tot',
            'departments.percentage AS d_percentage',
            DB::raw("count(institutions.department_id) AS total_institutions"))
    ->groupBy('departments.id')
    ->groupBy('departments.name')
    ->groupBy('departments.percentage')
    ->groupBy('departments.total_loan_amount')
    ->groupBy('departments.code')
    ->get();

    // dd($departmentss);

        return view('admin.departmentlisttable',compact('departments','departmentss'));

    }

    
    public function delete($id){

        $department = Department::findOrFail($id);
        $department->delete();

        return redirect('/admin/departments');
    }
}
