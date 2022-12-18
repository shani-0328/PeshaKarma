<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Customers;


class DateDifference extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datediff:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update date difference';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
         $customers =    DB::table('customers')
        ->selectRaw('id,date_diff_with_invoice,total_paid_percentage,payment_status,total_paid_amount,arius_amount_3_month,total_loan_amount,datediff(invoice_date, now()) as updated_invoice_datediff')
        ->get();
    
        foreach( $customers as  $customer)
        {

            $affected = DB::table('customers')
            ->where('id',  $customer->id)
            ->update(['date_diff_with_invoice' =>  $customer->updated_invoice_datediff]);
            
            $update_customer = new Customers;
            
            if($update_customer->total_paid_percentage > "100"){

                $update_customer->payment_status = "OverPaid"; 
    
            }elseif($update_customer->date_diff_with_invoice >= "1" && $update_customer->date_diff_with_invoice <= "29" && $update_customer->total_paid_percentage >= "1" && $update_customer->total_paid_percentage <= "12.5"){
                $update_customer->payment_status = "Settle"; 
            }elseif($update_customer->date_diff_with_invoice >= "30" && $update_customer->date_diff_with_invoice <= "59" && $update_customer->total_paid_percentage >= "1"  && $update_customer->total_paid_percentage <= "12.5"){
    
                $update_customer->payment_status = "Settle"; 
    
            }elseif($update_customer->date_diff_with_invoice >= "30" && $update_customer->date_diff_with_invoice <= "59" && $update_customer->total_paid_percentage > "1" && $update_customer->total_paid_percentage < "12.5" ){
                 $update_customer->payment_status = "Overdue"; 
            }elseif($update_customer->date_diff_with_invoice >= "60" && $update_customer->date_diff_with_invoice <= "89" && $update_customer->total_paid_percentage >= "12.5" && $update_customer->total_paid_percentage <= "25" ){
                $update_customer->payment_status = "Settle"; 
            }elseif($update_customer->date_diff_with_invoice >= "60" && $update_customer->date_diff_with_invoice <= "89" && $update_customer->total_paid_percentage >="12.5" &&  $update_customer->total_paid_percentage <="25"){
                 $update_customer->payment_status = "Overdue"; 
            }elseif($update_customer->date_diff_with_invoice >= "90" && $update_customer->date_diff_with_invoice <= "119" && $update_customer->total_paid_percentage >= "25" && $update_customer->total_paid_percentage <= "37.5"){
                $update_customer->payment_status = "Settle"; 
            }elseif($update_customer->update_customer >= "90" && $update_customer->date_diff_with_invoice <= "119" && $update_customer->total_paid_percentage > "25" && $update_customer->total_paid_percentage < "37.5" ){
                $update_customer->payment_status = "Overdue"; 
            }elseif($update_customer->date_diff_with_invoice >= "120" && $update_customer->date_diff_with_invoice <= "149" && $update_customer->total_paid_percentage >= "37.5" && $update_customer->total_paid_percentage <= "50" ){
                $update_customer->payment_status = "Settle"; 
            }elseif($update_customer->date_diff_with_invoice >= "120" && $update_customer->date_diff_with_invoice <= "149" && $update_customer->total_paid_percentage > "37.5" &&  $update_customer->total_paid_percentage < "50" ){
                 $update_customer->payment_status = "Overdue"; 
            }elseif( $update_customer->date_diff_with_invoice >= "150" &&  $update_customer->date_diff_with_invoice <= "179" &&  $update_customer->total_paid_percentage >= "50" &&  $update_customer->total_paid_percentage <= "62.5"){
                 $update_customer->payment_status = "Settle"; 
            }elseif( $update_customer->date_diff_with_invoice >= "150" &&  $update_customer->date_diff_with_invoice <= "179" &&  $update_customer->total_paid_percentage > "50" &&  $update_customer->total_paid_percentage < "62.5"){
                 $update_customer->payment_status = "Overdue"; 
            }elseif( $update_customer->date_diff_with_invoice >= "180" &&  $update_customer->date_diff_with_invoice <= "209" &&  $update_customer->total_paid_percentage >= "62.5" &&  $update_customer->total_paid_percentage <= "75"){
                 $update_customer->payment_status = "Settle"; 
            }elseif( $update_customer->date_diff_with_invoice >= "180" &&  $update_customer->date_diff_with_invoice <= "209" &&  $update_customer->total_paid_percentage > "62.5" &&  $update_customer->total_paid_percentage <  "75"){
                 $update_customer->payment_status = "Overdue"; 
            }elseif( $update_customer->date_diff_with_invoice >= "210" &&  $update_customer->date_diff_with_invoice <= "239" &&  $update_customer->total_paid_percentage >= "75" &&  $update_customer->total_paid_percentage <=  "87.5"){
                 $update_customer->payment_status = "Settle"; 
            }elseif( $update_customer->date_diff_with_invoice >= "210" &&  $update_customer->date_diff_with_invoice <= "239" &&  $update_customer->total_paid_percentage > "75" &&  $update_customer->total_paid_percentage <  "87.5"){
                 $update_customer->payment_status = "Overdue"; 
            }elseif( $update_customer->date_diff_with_invoice >= "240" &&  $update_customer->total_paid_percentage == "100"){
                 $update_customer->payment_status = "Paid"; 
            }elseif( $update_customer->total_paid_percentage == "100"){
                 $update_customer->payment_status = "Paid"; 
            }elseif($update_customer->date_diff_with_invoice >= "240" &&  $update_customer->total_paid_percentage < "100"){
                 $update_customer->payment_status = "Overdue"; 
            }elseif( $update_customer->date_diff_with_invoice >= "240" &&  $update_customer->total_paid_percentage > "100"){
                 $update_customer->payment_status = "OverPaid"; 
            }elseif($update_customer->updated_invoice_datediff >=90 &&  $update_customer_paid_percentage == 0){
                 $update_customer->payment_status = "Arrius"; 
            }elseif( $update_customer->arius_amount_3_month >=  $update_customer->total_paid_amount &&   $update_customer->updated_invoice_datediff >=90){
                 $update_customer->payment_status = "Arrius"; 
            }elseif( $update_customer->total_loan_amount == 0){
                 $update_customer->payment_status = "N/A"; 
            }else{
                 $update_customer->payment_status = "Overdue"; 
            }
    

             $update_customer->update();
       
        }

        echo "operation done";
       
    }
}
