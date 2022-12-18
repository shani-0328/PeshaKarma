<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customers;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::all();

        

        return view('admin.customers_list_sms', compact('customers'));
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
    public function store(Request $request)
    {
        //
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


    public function sendMessage(Request $request){

       $message = $request->input('message');
       $mobile = $request->input('mobile');
       $encodedMessage = urlencode($message);
       $authkey ='tcvr3dmknizp3jtmx';
       $senderId = 'Texdpt-CP';
       $userId = '103700';
       $postData = $request->all();

       $mobileNumber = implode('',$postData['mobile']);


       $arr = str_split($mobileNumber,'10');

       $mobiles= implode(",", $arr);
       

       $data = array(
        'user_id'=>$userId,
        'api_key'=>$authkey,
        'sender_id'=>$senderId,
        'message'=>$encodedMessage,
        'to'=> $mobiles

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


    return redirect()->back();

       
    }

    public function sendOneMessage(Request $request){

        //send sms to single person

        $mobile = $request->input("mobilenumber");
        $message = $request->input("message");
        $encodedMessage = urlencode($message);
        $authkey ='tcvr3dmknizp3jtmx';
        $senderId = 'Texdpt-CP';
        $userId = '103700';

        $data = array(
            'user_id'=>$userId,
            'api_key'=>$authkey,
            'sender_id'=>$senderId,
            'message'=>$encodedMessage,
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


        return redirect()->back();


    }
}
