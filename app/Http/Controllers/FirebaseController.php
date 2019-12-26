<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FirebaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('second message')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "dPOK70AfsYY:APA91bGoNgZr08ANunAp71cLhWKzha-hH2cx1jfX3bRyM1OCzgaRiRQoHDEm0edWcP0YyMgXDNtLL4BPrYCkcbU4G4-Kui4uMpTcIB_UrshjAg9HgJBL19uR_3TEZb7_XpF_WsVNmtB0";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);


        $downstreamResponse->numberSuccess();


        $downstreamResponse->numberFailure();



        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();

      //  dd($downstreamResponse);
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

    public function sendNotification(Request $request)
    {
$tokens=[];
        $tokens =array('token'=>'d4HVDGX2q0g:APA91bEfQtRvgoicVPa0VpqTx_qwljMXlmro4Y3siLKmpv80bVbdFfl3Bk4lI-17Yzerrin5UqQlZsjKSQoHUjoTvUrA4F2f-hOL8q2-koF_eyLxs5bca6HUwdE4TtOLnen-YDP8ps3v');
     //   $tokens = 'd4HVDGX2q0g:APA91bEfQtRvgoicVPa0VpqTx_qwljMXlmro4Y3siLKmpv80bVbdFfl3Bk4lI-17Yzerrin5UqQlZsjKSQoHUjoTvUrA4F2f-hOL8q2-koF_eyLxs5bca6HUwdE4TtOLnen-YDP8ps3v';
     //   $apns_ids = [];
        $responseData = [];
     //   $data = $request->all();
       // $users = $data['user_ids'];
        // for Android
      //  if ($FCMTokenData = $this->fcmToken->whereIn('user_id', $users)->where('token', '!=', null)->select('token')->get()) {
            // foreach ($tokens as $key => $value) {
            //     $tokens[] = $value->token;
            // }

            foreach ($tokens as $value) {
                $tokens[] = $value->token;
            }
            define('AIzaSyCUuq7VCHQ2g1As7avF8C0wlXKJxg_RnZc', 'AIzaSyCUuq7VCHQ2g1As7avF8C0wlXKJxg_RnZc');
            $msg = array(
                'body'  => 'This is body of notification',
                'title' => 'Notification',
                'subtitle' => 'This is a subtitle',
            );
            $fields = array(
                'registration_ids'  => $tokens,
                'notification'  => $msg
            );
            $headers = array(
                'Authorization: key=' . AIzaSyCUuq7VCHQ2g1As7avF8C0wlXKJxg_RnZc,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            $result = json_decode($result, true);
            $responseData['android'] = [
                "result" => $result
            ];
            curl_close($ch);
      //  }

        return $responseData;
    }
}
