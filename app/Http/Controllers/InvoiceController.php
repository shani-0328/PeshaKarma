<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customers;
use App\Models\Institutions;
use App\Models\Department;
use App\Models\Invoice;
use Session;
use Carbon;
use DB;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([

            'invoice_number'=>'required|unique:invoices,invoice_number',
            'guaranter1_Gov_ID'=>'required|min:9|max:11',
            'guaranter2_Gov_ID'=>'required|min:9|max:11',
            'guaranter1_phone_number'=>'required|min:10|max:10',
            'guaranter2_phone_number'=>'required|min:10|max:10'
        ]);

        $invoiceID = Invoice::findOrFail($invoice);

        // dd($invoiceID);

        // $invoice = new Invoice();


        // $invoice->invoice_number = $request->input('invoice_number');
        // $invoice->invoice_date= $request->input('invoice_date');
        // $invoice->year= $request->input('year');
        // $invoice->loan_amount = $request->input('loan_amount');
        // $invoice->customer_id = $request->input('customer_id');
        // $invoice->paid = $request->input('paid');
        // $invoice->balance = $request->input('balance');
        // $invoice->payment_method = $request->input('payment_method');
        // $invoice->number_of_installments= $request->input('number_of_installments');
        // $invoice->guaranter1_name = $request->input('guaranter1_name');
        // $invoice->guaranter2_name= $request->input('guaranter2_name');
        // $invoice->guaranter1_Gov_ID= $request->input('guaranter1_Gov_ID');
        // $invoice->guaranter2_Gov_ID = $request->input('guaranter2_Gov_ID');
        // $invoice->guaranter1_phone_number= $request->input('guaranter1_phone_number');
        // $invoice->guaranter2_phone_number = $request->input('guaranter2_phone_number');
        // $invoice->invoice_percentage = $request->input('invoice_percentage');
   
        // $invoice->save();

        // return redirect()->back();
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
        
        $invoice = Invoice::findOrFail($id);

        $cus_id = $invoice->customer_id;

        return view('admin.customer_invoice_edit',compact('invoice','cus_id'));
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
        $request->validate([
            'invoice_number'=>'required|unique:invoices,invoice_number',
            'guaranter1_Gov_ID'=>'required|min:9|max:11',
            'guaranter2_Gov_ID'=>'required|min:9|max:11',
            'guaranter1_phone_number'=>'required|min:10|max:10',
            'guaranter2_phone_number'=>'required|min:10|max:10'
        ]);

        $customer = Customers::findOrFail($id);
        
        $cus_institution = $customer->institution_id;
        $cus_department =$customer->department_id;

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;
        
        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');
        $customer_paid_percentage = $customer->total_paid_percentage;

        // dd($customer);
        $invoice = new Invoice();


        $invoice->invoice_number = $request->input('invoice_number');
        $invoice->invoice_date= $request->input('invoice_date');
        $invoice->year= $request->input('year');
        $invoice->loan_amount = $request->input('loan_amount');
        $invoice->customer_id = $request->input('customer_id');
       
        $invoice->payment_method = $request->input('payment_method');
        $invoice->number_of_installments= $request->input('number_of_installments');
        $invoice->guaranter1_name = $request->input('guaranter1_name');
        $invoice->guaranter2_name= $request->input('guaranter2_name');
        $invoice->guaranter1_Gov_ID= $request->input('guaranter1_Gov_ID');
        $invoice->guaranter2_Gov_ID = $request->input('guaranter2_Gov_ID');
        $invoice->guaranter1_phone_number= $request->input('guaranter1_phone_number');
        $invoice->guaranter2_phone_number = $request->input('guaranter2_phone_number');

     $test =    DB::table('customers')
        ->selectRaw('invoice_date,date_diff_with_invoice, datediff(invoice_date, now()) as updated_invoice_datediff')
        ->get();

            
            
      
        //special rate invoice
        if($invoice->number_of_installments != 8){

          $invoice->special_inovice_status = "Special";
          $invoice->special_rate =  $invoice->loan_amount/($invoice->number_of_installments);

          $customer->special_invoice_count += 1;
        }


   
        $customer->total_loan_amount +=  $invoice->loan_amount;

        $customer->total_balance = (($customer->total_loan_amount)- ($customer->total_paid_amount));

        $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;

    
        
        if($customer->invoice_date === null){

          $customer->invoice_date =   $invoice->invoice_date;
        }
       
        if($customer->invoice_first_invoice === null){

            $customer->invoice_first_invoice =   $invoice->invoice_number;
          }

        $institution = Institutions::where('id','=',$cus_institution)->first();

       

        $department = Department::where('id','=', $cus_department)->first();

       
        $current_date = Carbon\Carbon::now();
        $today_date = Carbon\Carbon::parse($current_date);
        $first_date = Carbon\Carbon::parse($customer->first_payment_date);
        $invoice_date = Carbon\Carbon::parse($customer->invoice_date);

        $datedifference = $first_date->diffInDays($today_date , false);
        $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);

        $monthly_installment = ($customer->total_loan_amount)/8;

        $arrius_monthly_installment = $datedifference/30;

            $total_to_be_paid = (($monthly_installment)*($arrius_monthly_installment+1));

            $arrius_month_amount = ($total_to_be_paid) - ($customer->total_paid_amount);

            $customer->arius_amount_3_month = $arrius_month_amount;

            $customer->date_diff_with_invoice = $datediffwithInvoice;


        //status

        if($customer->total_paid_percentage > "100"){

            $customer->payment_status = "OverPaid"; 

        }elseif($customer->date_diff_with_invoice >= "1" && $customer->date_diff_with_invoice <= "29" && $customer->total_paid_percentage >= "1" && $customer->total_paid_percentage <= "12.5"){

            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage >= "1"  && $customer->total_paid_percentage <= "12.5"){

            $customer->payment_status = "Settle"; 

        }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage > "1" && $customer->total_paid_percentage < "12.5" ){
            $customer->payment_status = "Overdue1"; 
        }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >= "12.5" && $customer->total_paid_percentage <= "25" ){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >="12.5" &&  $customer->total_paid_percentage <="25"){
            $customer->payment_status = "Overdue2"; 
        }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage >= "25" && $customer->total_paid_percentage <= "37.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage > "25" && $customer->total_paid_percentage < "37.5" ){
            $customer->payment_status = "Overdue3"; 
        }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage >= "37.5" && $customer->total_paid_percentage <= "50" ){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage > "37.5" && $customer->total_paid_percentage < "50" ){
            $customer->payment_status = "Overdue4"; 
        }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage >= "50" && $customer->total_paid_percentage <= "62.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage > "50" && $customer->total_paid_percentage < "62.5"){
            $customer->payment_status = "Overdue5"; 
        }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage >= "62.5" && $customer->total_paid_percentage <= "75"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage > "62.5" && $customer->total_paid_percentage <  "75"){
            $customer->payment_status = "Overdue6"; 
        }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage >= "75" && $customer->total_paid_percentage <=  "87.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage > "75" && $customer->total_paid_percentage <  "87.5"){
            $customer->payment_status = "Overdue7"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage == "100"){
            $customer->payment_status = "Paid"; 
        }elseif($customer->total_paid_percentage == "100"){
            $customer->payment_status = "Paid"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage < "100"){
            $customer->payment_status = "Overdue8"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage > "100"){
            $customer->payment_status = "OverPaid"; 
        }elseif($datediffwithInvoice >=90 && $customer_paid_percentage == 0){
            $customer->payment_status = "Arrius"; 
        }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datediffwithInvoice >=90){
            $customer->payment_status = "Arrius"; 
        }elseif($customer->total_loan_amount == 0){
            $customer->payment_status = "N/A"; 
        }else{
            $customer->payment_status = "Overdue9"; 
        }


        $invoice->save();

       

        $customer->invoice_count += 1;

        $customer->update();


    // dd($customer->department_id == $institution->department_id);
    // dd($customer->institution_id == $institution->id);

        if($customer->department_id == $institution->department_id && $customer->institution_id == $institution->id){
  
            $institution->total_loan_amount += $invoice->loan_amount; 

            if($institution->paid !=0){

                $institution->paid = ($institution->total_loan_amount) - ($institution->balance);
            }

            $institution->balance = ($institution->total_loan_amount) - ($institution->paid);

           
        }
     


        if($institution->department_id == $department->id){

            $department->total_loan_amount += $invoice->loan_amount; 

            $department->balance = (($department->total_loan_amount) - ($department->paid));

            $department->percentage = ($department->paid/$department->total_loan_amount)*100;

       

        }

        
        $institution->update();

        // dd($institution);

        
        $department->update();
   
        Session::flash('Add_invoice','The Invoice has been successfully Created.');


        return redirect('/admin/customers');
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


    public function invoicecreate($id){

        $customer = Customers::findOrFail($id);

        $cus_id= $customer->id; 

        return view('admin.customer_invoice_add', compact('customer','cus_id'));

    }

    public function invoiceUpdate(Request $request, $id){

        $invoice = Invoice::findOrFail($id);


        //update first invoice of customer

        $invoice_number = $invoice->invoice_number;

        $cus_id = $invoice->customer_id;

      
        $current_date = Carbon\Carbon::now();


        // dd($first_invoice);
        // ($invoice->loan_amount);

        $current_loan_amount = $invoice->loan_amount;

        $invoice->invoice_number = $request->input('invoice_number');
        $invoice->invoice_date= $request->input('invoice_date');
        $invoice->year= $request->input('year');
        $invoice->loan_amount = $request->input('loan_amount');
        $invoice->customer_id = $request->input('customer_id');
        $invoice->payment_method = $request->input('payment_method');
        $invoice->number_of_installments= $request->input('number_of_installments');
        $invoice->guaranter1_name = $request->input('guaranter1_name');
        $invoice->guaranter2_name= $request->input('guaranter2_name');
        $invoice->guaranter1_Gov_ID= $request->input('guaranter1_Gov_ID');
        $invoice->guaranter2_Gov_ID = $request->input('guaranter2_Gov_ID');
        $invoice->guaranter1_phone_number= $request->input('guaranter1_phone_number');
        $invoice->guaranter2_phone_number = $request->input('guaranter2_phone_number');


        $customer = Customers::where('id','=', $invoice->customer_id)->first();

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;

        $customer_paid_percentage = $customer->total_paid_percentage;

        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');

        $institution = Institutions::where('id','=',$customer->institution_id)->first();

        $department = Department::where('id','=',$customer->department_id)->first();

        // $customer->invoice_date= $invoice->invoice_date; (1st invoice update)


      
        $first_invoice = Invoice::where('customer_id','=',$cus_id)->first();

 
      
        if($invoice_number === $first_invoice->invoice_number){

            $customer->invoice_date = $invoice->invoice_date;
            // dd($customer->invoice_date);
        }

        if($invoice->number_of_installments != 8){

          $invoice->special_inovice_status = "Special";
          $invoice->special_rate =  $invoice->loan_amount/($invoice->number_of_installments);
        }
        if($invoice->number_of_installments == 8){

          $invoice->special_inovice_status = Null;
          $invoice->special_rate =  $invoice->loan_amount/($invoice->number_of_installments);
        }

      

        // customer calculation updates
        if($invoice->loan_amount >$current_loan_amount){
    
         $value = $invoice->loan_amount - $current_loan_amount;

         $customer->total_loan_amount += $value;
        }
        if($invoice->loan_amount < $current_loan_amount){
            
            $value =  $current_loan_amount - $invoice->loan_amount;
            $customer->total_loan_amount -= $value;
            // dd($customer->total_loan_amount);
        }

        $customer->total_balance = (($customer->total_loan_amount) - ($customer->total_paid_amount)); 

        if($customer->total_loan_amount != 0){
            $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;
          }else{

            $customer->total_paid_percentage = "0.00";
           
          }

        

        //institution calculation update

        if($invoice->loan_amount >$current_loan_amount){

            $value = $invoice->loan_amount - $current_loan_amount;
    
            $institution->total_loan_amount += $value;
        }

        if($invoice->loan_amount < $current_loan_amount){
    
            
            $value =  $current_loan_amount - $invoice->loan_amount;

            $institution->total_loan_amount -= $value;
            
        }

        if($institution->paid != 0){
            $institution->paid = (($institution->total_loan_amount) - ($institution->balance));
        }

        $institution->balance = ($institution->total_loan_amount) - ($institution->paid);

       

        if($institution->total_loan_amount != 0){
          
          $institution->percentage = (($institution->paid)/($institution->total_loan_amount))*100;
        }else{

          $institution->percentage = "0.00";
        }


         
        //department calculations

        if($invoice->loan_amount >$current_loan_amount){

            $value = $invoice->loan_amount - $current_loan_amount;
    
            $department->total_loan_amount += $value;
        }

        if($invoice->loan_amount < $current_loan_amount){
    
            $value =  $current_loan_amount - $invoice->loan_amount;

            $department->total_loan_amount -= $value;
            
        }


          // customer 3 months loan amount calculation

          $today_date = Carbon\Carbon::parse($current_date);
          $first_date = Carbon\Carbon::parse($customer->first_payment_date);
          $invoice_date = Carbon\Carbon::parse($customer->invoice_date);
          $monthly_installment = ($customer->total_loan_amount)/8;
 
          $datedifference = $first_date->diffInDays($today_date , false);
          $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);
 
          $arrius_monthly_installment = $datedifference/30; 
 
          $total_to_be_paid = (($monthly_installment)*($arrius_monthly_installment+1));
 
          $arrius_month_amount = ($total_to_be_paid) - ($customer->total_paid_amount);
 
          $customer->arius_amount_3_month = $arrius_month_amount;


          //status

          if($customer->total_paid_percentage > "100"){

            $customer->payment_status = "OverPaid"; 

        }elseif($customer->date_diff_with_invoice >= "1" && $customer->date_diff_with_invoice <= "29" && $customer->total_paid_percentage >= "1" && $customer->total_paid_percentage <= "12.5"){

            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage >= "1"  && $customer->total_paid_percentage <= "12.5"){

            $customer->payment_status = "Settle"; 

        }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage > "1" && $customer->total_paid_percentage < "12.5" ){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >= "12.5" && $customer->total_paid_percentage <= "25" ){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >="12.5" &&  $customer->total_paid_percentage <="25"){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage >= "25" && $customer->total_paid_percentage <= "37.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage > "25" && $customer->total_paid_percentage < "37.5" ){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage >= "37.5" && $customer->total_paid_percentage <= "50" ){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage > "37.5" && $customer->total_paid_percentage < "50" ){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage >= "50" && $customer->total_paid_percentage <= "62.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage > "50" && $customer->total_paid_percentage < "62.5"){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage >= "62.5" && $customer->total_paid_percentage <= "75"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage > "62.5" && $customer->total_paid_percentage <  "75"){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage >= "75" && $customer->total_paid_percentage <=  "87.5"){
            $customer->payment_status = "Settle"; 
        }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage > "75" && $customer->total_paid_percentage <  "87.5"){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage == "100"){
            $customer->payment_status = "Paid"; 
        }elseif($customer->total_paid_percentage == "100"){
            $customer->payment_status = "Paid"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage < "100"){
            $customer->payment_status = "Overdue"; 
        }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage > "100"){
            $customer->payment_status = "OverPaid"; 
        }elseif($datediffwithInvoice >=90 &&  $customer_paid_percentage == 0){
            $customer->payment_status = "Arrius"; 
        }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datediffwithInvoice >=90){
            $customer->payment_status = "Arrius"; 
        }elseif($customer->total_loan_amount == 0){
            $customer->payment_status = "N/A"; 
        }else{
            $customer->payment_status = "Overdue"; 
        }

        $customer->update();

        $department->update();

        $institution->update();
        $invoice->update();

        return redirect('admin/customer-details/'.$cus_id);   
       
    }

    public function delete($id){

        $invoice = Invoice::findOrFail($id);

        
        $invoice_number = $invoice->invoice_number;


        $cus_id = $invoice->customer_id;

        $customer = Customers::where('id','=', $invoice->customer_id)->first();

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;
        $customer_paid_percentage = $customer->total_paid_percentage;
      
        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');
        // $invoices

        $institution = Institutions::where('id','=',$customer->institution_id)->first();

        $department = Department::where('id','=',$customer->department_id)->first();


        // customer invoice date update

        $first_invoice = Invoice::where('customer_id','=',$cus_id)->first();
        // dd($first_invoice->invoice_number);
        if($invoice_number == $first_invoice->invoice_number){

          $customer->invoice_date = NULL;
          $customer->invoice_first_invoice = NULL;
          // dd($customer->invoice_date);
      }

     

        // customer calculation changes

        $customer->total_loan_amount -= $invoice->loan_amount;
        
        $customer->total_balance = (($customer->total_loan_amount) - ($customer->total_paid_amount)); 

        if($customer->total_loan_amount != 0){

            $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;

        }else{

            $customer->total_paid_percentage = "0.00";
          }

          if($customer->total_loan_amount == 0){

            $customer->date_diff_with_invoice = 0;
            $customer->payment_status = "N/A";
        }
          $current_date = Carbon\Carbon::now();
          // customer 3 months loan amount calculation
          $today_date = Carbon\Carbon::parse($current_date);
          $first_date = Carbon\Carbon::parse($customer->first_payment_date);
          $invoice_date = Carbon\Carbon::parse($customer->invoice_date);
          $monthly_installment = ($customer->total_loan_amount)/8;
 
          $datedifference = $first_date->diffInDays($today_date , false);
          $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);
 
          $arrius_monthly_installment = $datedifference/30; 
 
          $total_to_be_paid = (($monthly_installment)*($arrius_monthly_installment+1));
 
          $arrius_month_amount = ($total_to_be_paid) - ($customer->total_paid_amount);
 
          $customer->arius_amount_3_month = $arrius_month_amount;


        
          // institution Calculations

         $institution->total_loan_amount -= $invoice->loan_amount;
        
  
        
        if($institution->paid !=0){
            $institution->paid = (($institution->total_loan_amount) - ($institution->balance));
        }
        
         $institution->balance = ($institution->total_loan_amount) - ($institution->paid);

          if($institution->total_loan_amount != 0){
        
            $institution->percentage = (($institution->paid)/($institution->total_loan_amount))*100;

          }else{

            $institution->percentage = "0.00";
          }



          //department calculation changes
          
          $department->total_loan_amount -= $invoice->loan_amount;
          $department->paid = (($department->total_loan_amount) - ($department->paid));

          if($department->total_loan_amount != 0){
            
            $department->percentage = (($department->paid)/($department->total_loan_amount))*100;
          }else{

            $department->percentage = "0.00";
          }

        $cus_id = $invoice->customer_id;
       

        if($customer->invoice_count > 0){

          $customer->invoice_count -= 1;
        }

        if($customer->special_invoice_count > 0){

            $customer->special_invoice_count -= 1;
          }
       
        $cus_invoice = Invoice::where('customer_id','=',$cus_id)->get()->first();
     
           

            if($cus_invoice != null){
              $customer->invoice_date = $cus_invoice->invoice_date;
              $customer->invoice_first_invoice = $cus_invoice->invoice_number;
            }

            


            //status

            if($customer->total_paid_percentage > "100"){

                $customer->payment_status = "OverPaid"; 
    
            }elseif($customer->date_diff_with_invoice >= "1" && $customer->date_diff_with_invoice <= "29" && $customer->total_paid_percentage >= "1" && $customer->total_paid_percentage <= "12.5"){
    
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage >= "1"  && $customer->total_paid_percentage <= "12.5"){
    
                $customer->payment_status = "Settle"; 
    
            }elseif($customer->date_diff_with_invoice >= "30" && $customer->date_diff_with_invoice <= "59" && $customer->total_paid_percentage > "1" && $customer->total_paid_percentage < "12.5" ){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >= "12.5" && $customer->total_paid_percentage <= "25" ){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "60" && $customer->date_diff_with_invoice <= "89" && $customer->total_paid_percentage >="12.5" &&  $customer->total_paid_percentage <="25"){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage >= "25" && $customer->total_paid_percentage <= "37.5"){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "90" && $customer->date_diff_with_invoice <= "119" && $customer->total_paid_percentage > "25" && $customer->total_paid_percentage < "37.5" ){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage >= "37.5" && $customer->total_paid_percentage <= "50" ){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "120" && $customer->date_diff_with_invoice <= "149" && $customer->total_paid_percentage > "37.5" && $customer->total_paid_percentage < "50" ){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage >= "50" && $customer->total_paid_percentage <= "62.5"){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "150" && $customer->date_diff_with_invoice <= "179" && $customer->total_paid_percentage > "50" && $customer->total_paid_percentage < "62.5"){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage >= "62.5" && $customer->total_paid_percentage <= "75"){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "180" && $customer->date_diff_with_invoice <= "209" && $customer->total_paid_percentage > "62.5" && $customer->total_paid_percentage <  "75"){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage >= "75" && $customer->total_paid_percentage <=  "87.5"){
                $customer->payment_status = "Settle"; 
            }elseif($customer->date_diff_with_invoice >= "210" && $customer->date_diff_with_invoice <= "239" && $customer->total_paid_percentage > "75" && $customer->total_paid_percentage <  "87.5"){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage == "100"){
                $customer->payment_status = "Paid"; 
            }elseif($customer->total_paid_percentage == "100"){
                $customer->payment_status = "Paid"; 
            }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage < "100"){
                $customer->payment_status = "Overdue"; 
            }elseif($customer->date_diff_with_invoice >= "240" && $customer->total_paid_percentage > "100"){
                $customer->payment_status = "OverPaid"; 
            }elseif($datediffwithInvoice >=90 &&  $customer_paid_percentage == 0){
                $customer->payment_status = "Arrius"; 
            }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datediffwithInvoice >=90){
                $customer->payment_status = "Arrius"; 
            }elseif($customer->total_loan_amount == 0){
                $customer->payment_status = "N/A"; 
            }else{
                $customer->payment_status = "Overdue"; 
            }
    

        $customer->update();

        $institution->update();
     
        $department->update();
        
        $invoice->delete();

        Session::flash('delete_invoice','The Invoice has been successfully Deleted.');

        return redirect('admin/customer-details/'.$cus_id);
    }

    public function SpInvoice(){

      // $invoice

      $invoices = Invoice::where('special_inovice_status','=', 'special')->get();
        
      

      return view('admin.customer_sp_invoice', compact('invoices'));

    }
}
