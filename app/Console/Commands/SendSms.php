<?php

namespace App\Console\Commands;
use App\Models\Customers;


use Illuminate\Console\Command;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send a message to customers which payment staus is arrius';

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
       $customers = Customers::all();

       foreach($customers as $customer){

            if($customer->payment_status == "Arrius"){

                $mobile = $customer->phone_number;
                $message = "arrius message";
                $encodedmessage = urlencode($message);
                $authkey ='tcvr3dmknizp3jtmx';
                $senderId = 'Texdpt-CP';
                $userId = '103700';
                

                $data = array(
                    'user_id'=>$userId,
                    'api_key'=>$authkey,
                    'sender_id'=>$senderId,
                    'message'=>$encodedmessage,
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
        
        
            }
       }

       echo "successfully send";
    }
}
