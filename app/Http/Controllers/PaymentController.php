<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\Invoice;
use App\Models\Customers;
use App\Models\Installment;
use App\Models\Institutions;
use App\Models\Department;
use App\Models\CashBookReport;
use Session;
use Carbon;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::all();

        return view('admin.customers_payment_add',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $invoices = Invoice::all();
        // dd($invoices);
        // $invoices = Invoice::distinct('customer_id')->pluck('invoice_number')->toArray();

        // $results = Invoice::with('customer')->unique();

        $invoices =  Invoice::distinct()->get(['customer_id']);
        $customers = Customers::all();

        // dd($invoices);
        // $in = Invoice::distinct('customer_id')->pluck('category');

 
        
        return view('admin.payments_installment_add', compact('invoices','customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $installment = new Installment();

        $installment->customer_id = $request->input('customer_id');
        $installment->amount= $request->input('amount');
        // $installment->payment_date= $request->input('payment_date');
        $installment->paid_option = $request->input('paid_option');
        $installment->reference_number = $request->input('reference_number');
        $installment->cheque_number= $request->input('cheque_number');
      
        
        // dd($installment);
        $installment->save();


        return redirect('/admin/customers');
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
        

        $installment = Installment::findOrFail($id);

        $cus_id = $installment->customer_id;

        
        $cus_gov_id = $installment->customer->Gov_ID;

        return view('admin.payments_installment_edit', compact('installment','cus_id','cus_gov_id'));
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
        $customer = Customers::findOrFail($id);

        $cus_institution = $customer->institution_id;
        $cus_departmnet = $customer->department_id;

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;

        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');

        $current_date = Carbon\Carbon::now();

        $installment = new Installment();

        $installment->customer_id = $request->input('customer_id');
        $installment->amount= $request->input('amount');
        $installment->payment_date= $request->input('payment_date');
        $installment->paid_option= $request->input('paid_option');
        $installment->reference_number = $request->input('reference_number');
        $installment->cheque_number = $request->input('cheque_number');


        //new cashbook record creating

        $cashbook = new CashBookReport();

        $cashbook->Ref = $installment->reference_number;
        $cashbook->payment_date = $installment->payment_date;
        $cashbook->i_code = $customer->institution->code;
        $cashbook->institution = $customer->institution->name;
        $cashbook->paid_amount = $installment->amount;


            
        $customer->total_paid_amount +=  $installment->amount;

        $customer->total_balance = (($customer->total_loan_amount) - ($customer->total_paid_amount));

        $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;

        $customer_paid_percentage = $customer->total_paid_percentage;

        $cus_date = Customers::where('first_payment_date','=',$request->input('first_payment_date'))->first();

        // if($cus_date === null)

            $customer->first_payment_date =  $installment->payment_date;
        

            $current_date = Carbon\Carbon::now();
            $today_date = Carbon\Carbon::parse($current_date);
            $first_date = Carbon\Carbon::parse($customer->first_payment_date);
            $invoice_date = Carbon\Carbon::parse($customer->invoice_date);

            // 3month loan amount calculation

            $monthly_installment = ($customer->total_loan_amount)/8;

            $datedifference = $first_date->diffInDays($today_date , false);
            $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);

                $arrius_monthly_installment = $datedifference/30;

                $total_to_be_paid = (($monthly_installment)*($arrius_monthly_installment+1));

                $arrius_month_amount = ($total_to_be_paid) - ($customer->total_paid_amount);

                $customer->arius_amount_3_month = $arrius_month_amount;

                $customer->date_diff_with_invoice = $datediffwithInvoice;


           

        $institution = Institutions::where('id','=',$cus_institution)
        ->where('department_id','=',$cus_departmnet)->first();

        $department = Department::where('id','=', $cus_departmnet)->first();


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
        }elseif($datedifference >=90 &&  $customer->customer_paid_percentage == 0){
            $customer->payment_status = "Arrius"; 
        }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datedifference >=90){
            $customer->payment_status = "Arrius"; 
        }elseif($customer->total_loan_amount == 0){
            $customer->payment_status = "N/A"; 
        }else{
            $customer->payment_status = "Overdue"; 
        }


    


        

        
     
        $installment->save();
        $cashbook->save();
        $customer->update();


         // Institution tot, paid, balance, percentage calculate

         if(!is_null($institution)){

            $institution->paid += $installment->amount; 

            $institution->balance = (($institution->total_loan_amount) - ($institution->paid));
    
            if($institution->total_loan_amount != 0){
    
            $institution->percentage = (($institution->paid)/($institution->total_loan_amount))*100;
    
            }
         }

       
                


        $institution->update();

        // department tot, padi, percentage calculate

        if(!is_null($department)){

            $department->paid += $installment->amount;

            $department->balance = (($department->total_loan_amount) - ($department->paid));
    
            if($department->total_loan_amount != 0){
    
                $department->percentage = (($department->paid)/($department->total_loan_amount))*100;
            }
        }

       

  
        $department->update();

    // send sms
        
        $message = "You have made a payment of Rs"  .$installment->amount;
        $mobile = $customer->phone_number;
        $encodemessage = urlencode($message);
        $authkey ='tcvr3dmknizp3jtmx';
        $senderId = 'Texdpt-CP';
        $userId = '103700';
     

        $data = array(
            'user_id'=>$userId,
            'api_key'=>$authkey,
            'sender_id'=>$senderId,
            'message'=>$encodemessage,
            'to'=>$mobile,

        );

        $url = 'http://send.wiretree.lk/api/v2/send.php';
        $ch = curl_init();
        curl_setopt_array($ch ,array(

            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));

        // ignore SSL certificate verification

        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);


        // get response

        $output =  curl_exec($ch);

        //Print Error

        if(curl_error($ch))
        {
            echo "error:" . curl_error($ch);

        }

        curl_close($ch);

        Session::flash('Add_payment','The Payment has been successfully Created.');

        return redirect('/admin/installment-payment');
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

    public function findInvoiceName(Request $request){

        $data =Customers::select('initials','last_name','id')->where('id', $request->id)
        ->take(100)->get();

        return response()->json($data);
    }


    public function paymentcreate($id){

        $customer = Customers::findOrFail($id);

        

        $cus_last_name = $customer->last_name;

        $cus_id = $customer->id;

        $cus_gov_id = $customer->Gov_ID;

        $current_date = Carbon\Carbon::now();


        return view('admin.payments_installment_add', compact('customer', 'cus_last_name','cus_id','current_date','cus_gov_id'));

    }


    public function installmentupdate(Request $request, $id){


        $installment = Installment::findOrFail($id);

        $cus_id = $installment->customer_id;

        $customer = Customers::where('id','=', $installment->customer_id)->first();

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;

        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');

        $current_date = Carbon\Carbon::now();
        
        $today_date = Carbon\Carbon::parse($current_date);
        $first_date = Carbon\Carbon::parse($customer->first_payment_date);

        $invoice_date =   Carbon\Carbon::parse($customer->invoice_date);

        $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);

        $customer->date_diff_with_invoice = $datediffwithInvoice; 

        $institution = Institutions::where('id','=',$customer->institution_id)->first();

        $department = Department::where('id','=',$customer->department_id)->first();

        $current_payment_amount = $installment->amount;



        $installment->amount = $request->input('amount');
        $installment->customer_gov_id= $request->input('customer_gov_id');
        $installment->payment_date= $request->input('payment_date');
        $installment->paid_option= $request->input('paid_option');
        $installment->reference_number= $request->input('reference_number');
        $installment->cheque_number = $request->input('cheque_number');

        // customer 1st payment date update

        $customer->first_payment_date=$installment->payment_date;

        $customer_paid_percentage = $customer->total_paid_percentage;
        // 3month loan amount update


            $monthly_installment = ($customer->total_loan_amount)/8;

            $datedifference = $first_date->diffInDays($today_date , false);
            $datediffwithInvoice = $invoice_date->diffInDays($today_date, false);

            $arrius_monthly_installment = $datedifference/30; 

            $total_to_be_paid = (($monthly_installment)*($arrius_monthly_installment+1));

            $arrius_month_amount = ($total_to_be_paid) - ($customer->total_paid_amount);

            $customer->arius_amount_3_month = $arrius_month_amount;


        // customer calculations

        if($installment->amount >$current_payment_amount){
    
            $value = $installment->amount - $current_payment_amount;
   
            $customer->total_paid_amount += $value;
        }
    
        if($installment->amount < $current_payment_amount){
               
               $value =  $current_payment_amount - $installment->amount;
               $customer->total_paid_amount -= $value;
               // dd($customer->total_loan_amount);
        }

        $customer->total_balance = (($customer->total_loan_amount) - ($customer->total_paid_amount)); 

        if($customer->total_loan_amount != 0)
        {
            $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;
        }else{

            $customer->total_paid_percentage = "0.00";
          }


          // institution calculations


          
        if($installment->amount > $current_payment_amount){

            $value = $installment->amount - $current_payment_amount;
    
            $institution->balance -= $value;
        }

        if($installment->amount < $current_payment_amount){
    
            
            $value =  $current_payment_amount - $installment->amount;

            $institution->balance += $value;
            
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

        

          
        if($installment->amount > $current_payment_amount){

            $value = $installment->amount - $current_payment_amount;
    
            $department->total_loan_amount += $value;
        }

        if($installment->amount < $current_payment_amount){
    
            
            $value =  $current_payment_amount - $installment->amount;

            $department->total_loan_amount -= $value;
            
        }

            // department calculations
            
        $department->paid = (($department->total_loan_amount) - ($department->paid));

        if($department->total_loan_amount != 0){
          
          $department->percentage = (($department->paid)/($department->total_loan_amount))*100;
        }else{

          $department->percentage = "0.00";
        }

        // status
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
        }elseif($datedifference >=90 &&  $customer->customer_paid_percentage == 0){
            $customer->payment_status = "Arrius"; 
        }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datedifference >=90){
            $customer->payment_status = "Arrius"; 
        }elseif($customer->total_loan_amount == 0){
            $customer->payment_status = "N/A"; 
        }else{
            $customer->payment_status = "Overdue"; 
        }


        $installment->update();
        $customer->update();
        $institution->update();
        $department->update();


        return redirect('admin/customer-details/'.$cus_id);

    }


    public function delete($id){

        $installment = Installment::findOrFail($id);

        $customer = Customers::where('id','=',$installment->customer_id)->first();

        $institution = Institutions::where('id','=',$customer->institution_id)->first();

        $department = Department::where('id','=',$customer->department_id)->first();

        $cus_id = $installment->customer_id;

        $cus_tot_loan_amount = $customer->total_loan_amount;
        $cus_3_month_arius_amount = $customer->arius_amount_3_month;

        $cus_total_paid = $customer->total_paid_amount;
        number_format((float)$cus_total_paid, 2, '.', '');

        $customer->total_paid_amount -= $installment->amount; 

        $customer->total_balance = (($customer->total_loan_amount) - ($customer->total_paid_amount));

        if($customer->total_loan_amount != 0){
        
          $customer->total_paid_percentage = (($customer->total_paid_amount)/($customer->total_loan_amount))*100;
        }
  

         // 3month loan amount update
         $current_date = Carbon\Carbon::now();
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

         $customer_paid_percentage = $customer->total_paid_percentage;
         // institution calculations
        
        $institution->paid -= $installment->amount;

        $institution->balance = (($institution->total_loan_amount) - ($institution->paid));

        if($institution->total_loan_amount != 0){
            $institution->percentage = (($institution->paid)/($institution->total_loan_amount))*100;
        }
       

        // department calculations

        $department->paid -= $installment->amount; 
        $department->balance = (($department->total_loan_amount) - ($department->paid));

        if($department->total_loan_amount != 0){
            $department->percentage = (($department->paid)/($department->total_loan_amount))*100;
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
        }elseif($datedifference >=90 &&  $customer->customer_paid_percentage == 0){
            $customer->payment_status = "Arrius"; 
        }elseif($cus_3_month_arius_amount >= $cus_total_paid && $datedifference >=90){
            $customer->payment_status = "Arrius"; 
        }elseif($customer->total_loan_amount == 0){
            $customer->payment_status = "N/A"; 
        }else{
            $customer->payment_status = "Overdue"; 
        }

         

        $installment->delete();
        $customer->update();
        $institution->update();
        $department->update();

        Session::flash('delete_payment','The Payment has been successfully deleted.');
        return redirect('admin/customer-details/'.$cus_id);
    }

}
