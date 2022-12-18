<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institutions;
use App\Models\Customers;
use App\Models\Installment;
use App\Models\CashBookReport;


use DB;

class ReportsController extends Controller
{
    

    public function InstitutionReport(){



        // $institutions = Institutions::all();
        $institutions = Institutions::whereYear('created_at','2021')->get();
        // dd($institutions);


        return view('admin.report_institutions_monthly', compact('institutions'));
    }


    public function CustomersReport($id){

        $institution = Institutions::findOrFail($id);

         $customers = Customers::where('institution_id','=', $institution->id)->get();

        return view('admin.report_customers_monthly', compact('customers','institution'));
    }


    public function LetterReportInstitutions(){

            $institutions = Institutions::all();


        return view('admin.r_institutions_letter', compact('institutions'));
    }

    public function LetterReport($id){

        $institution = Institutions::findOrFail($id);

        $customers =  DB::table('customers')
        ->select(['customers.last_name', 'customers.Gov_ID','customers.occupation','customers.initials','customers.total_loan_amount'])
        ->join('invoices', 'invoices.customer_id', '=', 'customers.id')
        ->where('customers.institution_id','=', $institution->id)
        ->whereYear('invoices.invoice_date', '=', '2021')
        ->get();


        // dd($customers);
        // $customers = Customers::where('institution_id','=', $institution->id)->whereYear('invoice_date','2021')->get();

        // $installment_paymant= Customers::where()
        // dd($customers->total_loan_amount);

    


        return view('admin.r_institution_letter_customerslist', compact('institution', 'customers'));

    }


    public function AllCustomersReport(){


        $customers = Customers::all();


        return view('admin.report_allcustomers', compact('customers'));
    }

    public function allcustomers_u(){


        $customers = Customers::all();


        return view('admin.allcustomers_u', compact('customers'));
    }


    public function CashBookReport(){


        $installments = Installment::all()->unique('payment_date');

      
        $cashbooks = CashBookReport::select('payment_date','i_code','institution','Ref',\DB::raw('SUM(paid_amount) as total_val'))  
                                  ->groupBy('payment_date')
                                  ->groupBy('i_code')
                                  ->groupBy('institution')
                                  ->groupBy('Ref')
                                  ->orderBy('payment_date')
                                  ->get();

            
        return view('admin.report_cashbook', compact('cashbooks'));
    }
    

    public function daily_payments_report(){

        $payments = Installment::all();
        return view('admin.report_daily_payments', compact('payments'));

    }

    public function SearchByDate(Request $request){

            // $cashbooks = CashBookReport::where('payment_date','>=',$request->from)
            // ->where('payment_date','<=',$request->to)->get();

            $cashbooks = CashBookReport::select('payment_date','i_code','institution','Ref',\DB::raw('SUM(paid_amount) as total_val'))  
            ->groupBy('payment_date')
            ->groupBy('i_code')
            ->groupBy('institution')
            ->groupBy('Ref')
            ->orderBy('payment_date')
            ->where('payment_date','>=',$request->from)
            ->where('payment_date','<=',$request->to)
            ->get();
      
            
            return view('admin.report_cashbook', compact('cashbooks'));
    }

    public function loginstitutionreport(){


        $institutions = Institutions::whereYear('created_at','2021')->get();

        return view('admin.report_institutions_logbook', compact('institutions'));
    }

    public function logbook($id){

        $institution = Institutions::findOrFail($id);

        $customers = Customers::where('institution_id','=', $institution->id)->get();

       return view('admin.logbook', compact('customers','institution'));
    }
     
}
