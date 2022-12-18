<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Invoice;
use App\Models\Institutions;
use App\Models\Installment;
use App\Models\Department;

use DB;
use Session;
use Carbon;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::all();

        // $Invoices = Invoice::all();

        // dd($invoices);
        // dd($invoices->;

        // $invoices = Invoice::all()->unique('customer_id');
        // $invoices = DB::table('invoices')
        // ->join('customers', 'customers.id','=','invoices.customer_id')
        // ->select(
        //     'invoices.invoice_number AS I_num',
        //     'invoices.customer_id AS cus_id')
        // ->groupBy('invoices.invoice_number')
        // ->groupBy('invoices.customer_id')
        // ->get();

        
    //     $customers = DB::table('customers')
    //     ->join('invoices', 'invoices.customer_id', '=', 'customers.id')
    //     ->select(
    //         'customers.id AS ID',
    //         'customers.last_name AS name',
    //         'customers.Gov_ID AS GOV',
    //         'customers.total_loan_amount AS loan',
    //         'customers.total_paid_percentage AS percentage',
    //         DB::raw("count(invoices.customer_id) AS total_invoices"))
    // ->groupBy('customers.id')
    // ->groupBy('customers.last_name')
    // ->groupBy('customers.Gov_ID')
    // ->groupBy('customers.total_loan_amount')
    // ->groupBy('customers.total_paid_percentage')
    // ->get();

            // dd($inv  oices);

// dd($customers);
        return view('admin.customers',compact('customers'));

    }
    public function indexall()
    {
        $customers = Customers::all();

        

        // $invoices =  Invoice::distinct()->get(['customer_id']);

        

        return view('admin.customerslist',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $institutions = Institutions::all();

        $departments = Department::all();
        return view('admin.customers_add', compact('institutions','departments'));
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

            'initials'=>'required',
            'last_name'=>'required',
            'Gov_ID'=>'required|unique:customers,Gov_ID|min:9|max:11',
            'occupation'=>'required',
            'address'=>'required',
            'phone_number'=>'required|unique:customers,phone_number|min:10|max:10',
            'office_phone_number'=>'required|min:10|max:10',
            'place_to_get_paid'=>'required'
        ]);
        
        $customer = new Customers();

        $customer->initials = $request->input('initials');
        $customer->last_name= $request->input('last_name');
        $customer->Gov_ID = $request->input('Gov_ID');
        $customer->occupation = $request->input('occupation');
        $customer->address= $request->input('address');
        $customer->phone_number = $request->input('phone_number');
        $customer->office_phone_number = $request->input('office_phone_number');
        $customer->department_id= $request->input('department_id');
        $customer->institution_id= $request->input('institution_id');
        $customer->place_to_get_paid = $request->input('place_to_get_paid');

        $customer->save();
        Session::flash('Add_customers','The customer has been successfully Created.');    
        // $invoice = new Invoice();


        // $invoice->invoice_number = $request->input('invoice_number');
        // $invoice->invoice_date= $request->input('invoice_date');
        // $invoice->loan_amount = $request->input('loan_amount');
        // $invoice->paid = $request->input('paid');
        // $invoice->number_of_installments= $request->input('number_of_installments');
        // $invoice->payment_method = $request->input('payment_method');
        // $invoice->guaranter1_name = $request->input('guaranter1_name');
        // $invoice->guaranter2_name= $request->input('guaranter2_name');
        // $invoice->guaranter1_Gov_ID = $request->input('guaranter1_Gov_ID');
        // $invoice->guaranter2_Gov_ID = $request->input('guaranter2_Gov_ID');
        // $invoice->guaranter1_phone_number= $request->input('guaranter1_phone_number');
        // $invoice->guaranter2_phone_number = $request->input('guaranter2_phone_number');
        // $invoice->gove_id = $request->input('gove_id');
   
        //     $invoice->save();

            return redirect()->back(); 
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
       $customer = Customers::findOrFail($id);

       $institutions = Institutions::all();

       $departments = Department::all();

       $institutionss = Institutions::pluck('name', 'id')->all();

       $departmentss = Department::pluck('name','id')->all();

    //    dd($institutionss);

        return view('admin.customers_edit',compact('customer','institutions','departments','institutionss','departmentss'));
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
        $request->validate([

            'initials'=>'required',
            'last_name'=>'required',
            'Gov_ID'=>'required|min:9|max:11',
            'occupation'=>'required',
            'address'=>'required',
            'phone_number'=>'required|min:10|max:10',
            'office_phone_number'=>'required|min:10|max:10',
            'department_id'=>'required',
            'institution_id'=>'required'
            
        ]);
        $customer = Customers::findOrFail($id);

        $customer->initials = $request->input('initials');
        $customer->last_name= $request->input('last_name');
        $customer->Gov_ID =$request->input('Gov_ID');
        $customer->occupation = $request->input('occupation');
        $customer->address = $request->input('address');
        $customer->phone_number = $request->input('phone_number');
        $customer->office_phone_number = $request->input('office_phone_number');
        $customer->department_id = $request->input('department_id');
        $customer->institution_id = $request->input('institution_id');
        $customer->institution_id = $request->input('institution_id');
        
        $customer->update();
        Session::flash('edit_customers','The customer has been successfully Upadated.'); 
        return redirect('/admin/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {

    //     $customer = Customers::findOrFail($id);

    //     $customer->delete();
    //     //Session::flash('delete_customers','The customer has been successfully Deleted.'); 

    //     return redirect('/admin/customers');
    // }

    public function delete($id){

        $customer = Customers::findOrFail($id);
        $customer->delete();

return redirect('/admin/customers');
    }



    public function findHotelName(Request $request){

        $data =Institutions::select('name','id')->where('department_id', $request->id)
        ->take(9999)->get();

        return response()->json($data);
    }


    public function customer_details($id){

        $customer = Customers::findOrFail($id); 
        $cus_id  = $customer->id;

        $installments  = Installment::where('customer_id', '=', $cus_id)->get();

        // $invoice = Invoice::findOrFail($id); 
        // $invoice = Invoice::findOrFail($id);

      

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;

        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');

     
        $current_date = Carbon\Carbon::now();

        $today_date = Carbon\Carbon::parse($current_date);
        $invoice_date = Carbon\Carbon::parse($customer->invoice_date);

        $datedifference = $invoice_date->diffInDays($today_date , false);

        $customer_paid_percentage = $customer->total_paid_percentage;

        $invoices  = Invoice::where('customer_id', '=', $cus_id)->orderBy('id', 'desc')->paginate(1);

        $datediffinvoice =  $customer->date_diff_with_invoice;
  
        // dd($customer_pa id_percentage);
        // $installment = Installment::

    return view('admin.customer_details', compact('customer', 'cus_tot_loan_amount', 'invoices','cus_total_paid','cus_3_month_arius_amount','datedifference','customer_paid_percentage','installments','datediffinvoice'));
    }

    public function GetSubCatAgainstMainCatEdit($id){
        echo json_encode(DB::table('institutions')->where('department_id', $id)->get());
    }


    public function paymentsettle(Request $request, $id){

        $customer = Customers::findOrFail($id);

        $cus_id = $customer->id;

        $settle_amount = $request->input('settle_amount');

        $customer->voucher_number = $request->input('voucher_number');

        $customer->total_paid_amount -= $settle_amount;


        $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;

        $customer->total_balance = ($customer->total_loan_amount) - ($customer->total_paid_amount);

        $institution = Institutions::where('id', '=', $customer->institution_id)->first();
        $department = Department::where('id', '=', $customer->department_id)->first();

        $institution->paid  -= $settle_amount;

        $institution->balance = ($institution->total_loan_amount) - ($institution->paid);
        $institution->percentage = (($institution->paid)/($institution->total_loan_amount))*100;


        $department->paid  -= $settle_amount;

        $department->balance = ($department->total_loan_amount) - ($department->paid);
        $department->percentage = (($department->paid)/($department->total_loan_amount))*100;

        $customer->update();
        $institution->update();
        $department->update();



     return redirect()->back();
    }
}
