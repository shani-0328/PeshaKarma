<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Institutions;
use App\Models\Invoice;
use DB;

class DashboardController extends Controller
{
    //

    public function totalsales(){
 
     $customers =  DB::table('customers')
     ->select(['customers.total_loan_amount', 'customers.total_paid_amount','customers.id'])
     ->join('invoices', 'invoices.customer_id', '=', 'customers.id')
     ->whereYear('invoices.invoice_date', '=', '2021')
     ->get();


        $total_sales = $customers->sum('total_loan_amount');

        $total_count = Customers::count();

        $total_paid = $customers->sum('total_paid_amount');

        $ratio = null;

      
        if($total_sales != 0){

            $ratio = ($total_paid/$total_sales)*100;
        }
        
        $institutions = Institutions::whereYear('created_at','2021')->get();

        return view('admin.dashboard', compact('total_sales','total_count','total_paid','ratio','institutions'));


    }
}
