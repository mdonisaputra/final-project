<?php

namespace App\Http\Controllers\Auth;

use App\Events\OtpCodeStoredEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
        $validator = Validator::make($allRequest,[
            'nama' => 'required',
            'email' => 'required|unique:users,email|email',
            'username' => 'required|unique:users,username'
        ]);

        //respon error valitdation
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($allRequest);

        do {
            $random = mt_rand(100000 , 999999);
            $check = OtpCode::where('otp', $random)->first();
        } while ($check);

        $now = Carbon::now();

        $otp_code = OtpCode::create([
            'otp' => $random,
            'valid_until' => $now->addMinutes(10),
            'user_id' => $user->id
        ]);


        //kirim email otp code ke email register
        event(new OtpCodeStoredEvent($otp_code , true));

        return response()->json([
            'success' => true,
            'message' => 'Data User berhasil dibuat',
            'data' => [
                'user' => $user,
                'otp_code' => $otp_code
            ]
        ]);
    }
}
