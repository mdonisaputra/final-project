<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OtpCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\OtpCodeStoredEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegenerateOtpCodeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $allRequest = $request->all();


        $validator = Validator::make($allRequest, [
            'email'   => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email' , $request->email)->first();

        
        if($user->otp_code){
            
            $user->otp_code->delete();
        }
        

        do {
            $random = mt_rand(100000 , 999999);
            $check = OtpCode::where('otp',$random)->first();

        } while ($check);
        
        $now = Carbon::now();


        $otp_code = OtpCode::create([
            'otp' => $random,
            'valid_until' => $now->addMinutes(5),
            'user_id' => $user->id

        ]);

        //kirim email otp code ke email register
        event(new OtpCodeStoredEvent($otp_code)); //, false));

        return response()->json([
            'success' => true,
            'mesaage' => 'Otp Code berhasil digenerate',
            'data' => [
                'user' => $user,
                'otp_code' => $otp_code
            ]

        ]);
    }
}
